#!/bin/bash

for file in 'lhfa_boys_p_exp.txt' 'lhfa_girls_p_exp.txt'; do
    head -n 732 $file > $file-length
    head -n 1 $file > $file-height
    tail -n +733 $file >> $file-height
done
