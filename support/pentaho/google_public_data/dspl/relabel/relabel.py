#!/usr/local/bin/python2.6
# -*- coding: cp1252 -*-

# Thibaut Labarre (tlabarre)

# python2.6 query2documents.py /corpora/LDC/LDC10E18/data/2010_training_entity_query_list.xml output/queries

# import modules
import re
import sys
import os
import operator
import subprocess
from xml.dom import minidom
import codecs

# dataset_file to convert
'''
dataset_file = 'dataset.xml' # sys.argv[1]
description_file = 'description.txt' # sys.argv[2]
output_file = 'output.xml' # sys.argv[3]
'''

dataset_file = sys.argv[1]
description_file = sys.argv[2]
output_file = sys.argv[3]

# class for the concepts
class Description:

    # initialization of the class
    def __init__(self,description_type,concept_id):
        self.description_type = description_type
        self.concept_id = concept_id
        self.description = {}

    # add a language description of the concept
    def add_language(self,lang,name,description):
        self.description[lang] = {}
        self.description[lang]['name'] = unicode(name, 'utf-8')
        self.description[lang]['description'] = unicode(description, 'utf-8')

class Description_list:

    # initialization of the class
    def __init__(self,descriptionFile=None):
        self.list = {}
        if descriptionFile:
            self.create(descriptionFile)
        
    # generic error function to write to stderr
    def error(self, errorText):
        print >> sys.stderr, '***ERROR***:\n'
        print >> sys.stderr, errorText

    # read descriptions from file
    def create(self,descriptionFile):
        concept_file = open(descriptionFile,'r')
        for line in concept_file.readlines():
            splitline = line.strip().split('\t')
            if len(splitline)<4:
                self.error('ERROR: a tab is missing in the description.txt file')
            description_type = splitline[0]
            if not description_type in self.list:
                self.list[description_type] = {}
            concept_id = splitline[1]
            if not concept_id in self.list[description_type]:
                self.list[description_type][concept_id] = Description(description_type,concept_id)
            self.list[description_type][concept_id].add_language(splitline[2],splitline[3],splitline[4])

# FONCTION THAT INSERTS THE RELABELING
def insert(node,regexp,node_type,field):
    for value in node.childNodes:
        if not value.nodeType == 3: # getting rid of text nodes
            concept_name = ''
            # find the concept name
            parsedLine = re.match(regexp,value.firstChild.toxml().strip())
            if parsedLine:
                concept_id = parsedLine.group("concept_id")
                if concept_id in description.list[node_type]:
                    value.firstChild.replaceWholeText(description.list[node_type][concept_id].description['en'][field])
                    # adding french translation
                    french = dom.createElement("value")
                    french.attributes['xml:lang']='fr'
                    french.appendChild(dom.createTextNode(description.list[node_type][concept_id].description['fr'][field]))
                    node.appendChild(french)


# list of concepts
description = Description_list(description_file)


# script to add the dataset information
dom = minidom.parse(dataset_file)
infos=dom.childNodes

# for each concept in the xml file
for info in infos:
    # replace concept name
    for node in info.childNodes: # You may change to "Result" or "Value" only
        if not node.nodeType == 3:

            # RELABEL INFO AND PROVIDERS
            if node.nodeName in ['info','provider']:
                for value in node.childNodes:
                    if not value.nodeType == 3: # getting rid of text nodes
                        insert(value,"\*\* INSERT \w+ (?P<concept_id>\w+) \*\*",node.nodeName,'name')

            # RELABEL CONCEPTS
            if node.nodeName in 'concepts':            
                # for each concept in the xml file
                for concept in node.childNodes:
                    if not concept.nodeType == 3:
                        # replace concept name
                        for field in ['name','description']:
                            for item in concept.getElementsByTagName(field): # You may change to "Result" or "Value" only
                                insert(item,"\*\* INSERT(\w|\s)+: (?P<concept_id>\w+) \*\*",concept.nodeName,field)



#write to file
codecs.open(output_file,"wb","utf-8").write(dom.toxml())
