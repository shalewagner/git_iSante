#!/bin/bash

status=`svn status`

if [[ -n $status ]]; then
    echo Working copy must be unmodified.
    exit 1
else
    exit 0
fi
