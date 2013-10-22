#!/bin/bash

clear
echo Please wait Wormbase  link generator script is executing..

for i in *.xml;
do
    ./WormbaseLinkGenerator.pl WS175/ $i  > /dev/null 2>&1 
done

mv data_report* ./log/
mv *.xml ./xml/

clear
echo Done....
echo "Please download linked file(s) from the ftp window"     

