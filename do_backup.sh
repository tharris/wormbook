#!/bin/bash

###########################################
# Backup WormBase information
###########################################

BACKUP_HOST=wb-dev.oicr.on.ca
BACKUP_USER=tharris

# Which host are we running on?
THIS_HOST=`hostname`
DATE=`date +%Y-%m-%d`
BACKUPS_ROOT=/home/todd/backups


##############################
# BRIE6
#    WormBook prodution site and wbg database
#
##############################
if [ ${THIS_HOST} = "brie6.cshl.edu" ]
then

    #######################
    #  WORMBOOK / THE WBG
    #######################
    # Create a suitable backup directory
    echo "Backing up WormBook to ${BACKUP_HOST}";

    # Dump the mysql database for the wbg
    /usr/local/mysql/bin/mysqldump --socket=/usr/local/mysql/mysql.sock \
	  -u root  wormbook_wordpress | \
          gzip -c >  /usr/local/bookworm/mysqldump/${DATE}-wormbook_wordpress-worm_breeders_gazette.sql.gz


    # Rsync the site directory for easy restoration
    # No reason to maintain daily backups; 1 copy is sufficient.
#     rsync -avv --rsh=ssh --exclude logs/ /usr/local/bookworm/ \
#	  ${BACKUP_USER}@${BACKUP_HOST}:backups/wormbook/production/.
     rsync -avv --rsh=ssh /usr/local/bookworm/ \
	  ${BACKUP_USER}@${BACKUP_HOST}:backups/wormbook/production/.

fi
  


##############################
# BRIE3
# WormBook dev site
##############################
if [ ${THIS_HOST} = "brie3.cshl.edu" ]
then

    #######################
    #  WORMBOOK / THE WBG
    #######################
    # Create a suitable backup directory
    echo "Backing up WormBook to ${BACKUP_HOST}";

    # Dump the mysql database for the wbg
    /usr/local/mysql/bin/mysqldump --socket=/usr/local/mysql/mysql.sock \
	  -u root  wormbook_wordpress | \
          gzip -c >  /usr/local/bookworm/mysqldump/${DATE}-wormbook_wordpress-worm_breeders_gazette.sql.gz


    # Rsync the site directory for easy restoration
    # No reason to maintain daily backups; 1 copy is sufficient.
     rsync -avv --rsh=ssh --exclude logs/ /usr/local/bookworm/ \
	  ${BACKUP_USER}@${BACKUP_HOST}:backups/wormbook/dev/.

fi
