'''
Execute with Python 2.6
Developped by Thibaut Labarre for iSante (May 2012)

This script parses a link from the google public data explorer iSante dataset
and converts it to an SQL query that can be used on the iSante database
(See http://www.google.com/publicdata)
'''

# importing libraries
import re
from datetime import date

# Paste your link below and run the code (F5)
link = "http://www.google.com/publicdata/explore?ds=feu2re4f96ru1_&draft#!ctype=l&strail=false&bcs=d&nselm=h&met_y=population&fdim_y=pregnant:1&scale_y=lin&ind_y=false&rdim=department&idim=department:9:1&ifdim=department&tstart=1214204400000&tend=1243407600000&hl=fr&dl=fr&ind=false"

# Working examples of links
# link = "met_y=population&fdim_y=patientStatus:7&fdim_y=pregnant:1&scale_y=lin&ind_y=false&rdim=department&idim=department:9:2:4&idim=clinic:93301:91100:93401:41201:41100&ifdim=department&tstart=1190617200000&tend=1220511600000&ind=false&draft"
# link = "http://www.google.com/publicdata/explore?ds=feu2re4f96ru1_&draft=&hl=en&dl=en#!ctype=l&strail=false&bcs=d&nselm=h&met_y=population&fdim_y=clinic:42301&fdim_y=patientStatus:7&fdim_y=pregnant:0&scale_y=lin&ind_y=false&rdim=sex&idim=sex:1:2:3:0&ifdim=sex&tdim=true&tstart=1206255600000&tend=1333177200000&hl=en_US&dl=en&ind=false"

# debug printing, making sure the link is right
print link

# Initializing variables
groupby = {}
where = {}
tstart = ''
tend = ''

# Regular Expression link parser
matches = re.findall("\&?(?P<name>\w+)=(?P<value>(\w|:)+)\&?",link )

# loop over matches
for match in matches:
    name = match[0]
    value = match[1]
    selection = value.split(':')

    # create SQL group by section from idim in the link
    if name == 'idim':
        groupby[selection[0]] = selection[1:len(selection)]

    # create SQL where section from fdim_y in the link
    if name == 'fdim_y':
        where[selection[0]] = selection[1:len(selection)]

    # create SQL start date
    if name == 'tstart':
        tstart = value

    # create SQL end date
    if name == 'tend':
        tend = value

# debug printing the created sections
print where
print groupby
print date.fromtimestamp(float(tstart)/1000)
print date.fromtimestamp(float(tend)/1000)

# function to build the aggregate SQL query (counts) from the sections
def aggregation_query():
    query = 'SELECT '

    for idim in groupby:
        query += '`' + idim + '`,'

    query += 'SUM(`population`) FROM `dw_aggregated_patient`'

    query += ' WHERE '

    if tstart != '' and tend != '':
        query += 'snapshot_date BETWEEN DATE(\'' + str(date.fromtimestamp(float(tstart)/1000)) + '\') AND DATE(\'' + str(date.fromtimestamp(float(tend)/1000)) + '\') AND '

    sep = ''
    for fdim_y in where:
        query += sep + '`' + fdim_y + '` IN (' + ','.join(where[fdim_y]) + ')'
        sep = ' AND '

    query += ' GROUP BY '

    query += ','.join(groupby)

    query += ' HAVING '

    sep = ''
    for idim in groupby:
        query += sep + '`' + idim + '` IN (' + ','.join(groupby[idim]) + ')'
        sep = ' AND '
    return query

# call that function
print aggregation_query()

# function to build the identified SQL query (with patient IDs) from the sections
def identified_query():
    query = 'SELECT '

    for idim in groupby:
        query += '`' + idim + '`,'

    query += 'patientID FROM `dw_snapshots`'

    query += ' WHERE '

    if tstart != '' and tend != '':
        query += 'snapshot_date BETWEEN DATE(\'' + str(date.fromtimestamp(float(tstart)/1000)) + '\') AND DATE(\'' + str(date.fromtimestamp(float(tend)/1000)) + '\') AND '

    sep = ''
    for fdim_y in where:
        query += sep
        if '0' in where[fdim_y]:
            query += '(`' + fdim_y + '` IS NULL OR '
        query += '`' + fdim_y + '` IN (' + ','.join(where[fdim_y]) + ')'
        if '0' in where[fdim_y]:
           query += ')' 
        sep = ' AND '

    query += ' GROUP BY patientID,'

    query += ','.join(groupby)

    query += ' HAVING '

    sep = ''
    for idim in groupby:
        query += sep + '`' + idim + '` IN (' + ','.join(groupby[idim]) + ')'
        sep = ' AND '
    return query

# call that function
print identified_query()
