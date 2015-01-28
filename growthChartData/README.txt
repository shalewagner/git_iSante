This directory contains all the raw data and JSON representations needed for the growth charts.

CDC/ - raw growth data from the CDC
WHO/ - raw growth data from the WHO
growthDataToJson.pl - script for converting raw data files in CDC/ and WHO/ into JSON format
growthChartLmsData.js - output of growthDataToJson.pl, only L, M and S numbers are included
z-scores.nb - Mathematica notebook for generating a table to map percentiles to z-scores
z-scores.json - output of z-scores.nb, percentiles range from 50.00 to 99.95 with steps of 00.05.
