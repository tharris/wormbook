#!/bin/bash
MUSER="wormbook"
MPASS="3l3g@nz"
MDB="wordpress_wormbook_gazette"
MHOST="mysql.wormbook.org" 

# Detect paths
MYSQL=$(which mysql)
AWK=$(which awk)
GREP=$(which grep)
 
if [ $# -ne 3 ]
then
    echo "Usage: $0 {MySQL-User-Name} {MySQL-User-Password} {MySQL-Database-Name}"
echo "Drops all tables from a MySQL"
#exit 1
fi
 
TABLES=$($MYSQL -u $MUSER -h $MHOST -p$MPASS $MDB -e 'show tables' | $AWK '{ print $1}' | $GREP -v '^Tables' )
 
for t in $TABLES
do
    echo "Deleting $t table from $MDB database..."
    $MYSQL -u $MUSER -h $MHOST -p$MPASS $MDB -e "drop table $t"
done