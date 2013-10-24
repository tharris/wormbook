#!/bin/bash

clear
VERSION=$1

echo Please wait Wormbase  link generator script is executing..

for i in *.xml;
do
    ./WormbaseLinkGenerator.pl --links_from $VERSION/
	                       --defs-file WormbaseLinks.def \
	                       --xml-files $i > /dev/null 2>&1

#    ./WormbaseLinkGenerator.pl --links_from mining.wormbase.org \
#	                       --defs-file WormbaseLinks.def \
#                               --locus_from http://www.sanger.ac.uk/Projects/C_elegans/LOCI/loci_all.txt \
#	                       --xml-files $i > /dev/null 2>&1
#
done

mv data_report* ./log/
mv *.xml ./xml/

clear
echo Done....
echo "Please download linked file(s) from the ftp window"     

