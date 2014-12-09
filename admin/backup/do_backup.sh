#!/bin/bash

###########################################
# Backup WormBase information
###########################################

BACKUP_HOST=wb-dev.oicr.on.ca
BACKUP_USER=tharris

# Which host are we running on?
THIS_HOST=`hostname`
DATE=`date +%Y-%m-%d`

#######################
#  WORMBOOK / THE WBG
#######################
# Create a suitable backup directory
echo "Backing up WormBook to ${BACKUP_HOST}";

# Dump the mysql database for the wbg
/usr/bin/mysqldump  \
    -h localhost \
    -u wormbook -p3l3g@nz  wordpress_wormbook_gazette | \
    gzip -c > /usr/local/wormbook/mysqldump/${DATE}-wormbook_wordpress-worm_breeders_gazette.sql.gz


    # Rsync the site directory for easy restoration
    # No reason to maintain daily backups; 1 copy is sufficient.
#     rsync -avv --rsh=ssh --exclude logs/ /usr/local/bookworm/ \
#	  ${BACKUP_USER}@${BACKUP_HOST}:backups/wormbook/production/.
#rsync -avv --rsh=ssh --exclude Maildir/ --exclude logs/ /home/tharris70/ \
#     ${BACKUP_USER}@${BACKUP_HOST}:backups/wormbook/dreamhost/.

