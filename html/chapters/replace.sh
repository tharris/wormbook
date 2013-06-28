#!/bin/bash

perl -p -i -e 's|<\/body>/<\!\-\-\#include virtual=\"\/ssi\/footer\.html\" \-\-><\/body>|g' www*/*.html