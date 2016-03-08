#!/bin/sh

# Change Directory
cd /var/www; 

# contents backup
tar -zcf /root/backup/contents_`/bin/date +\%Y\%m\%d`.tar.gz engp

# database backup
mysqldump --user=root --password=1hkIW40XGPTc --host=localhost engp > /root/backup/database_`/bin/date +\%Y\%m\%d`.sql

# 30day old data delete
find /root/backup -name "contents_*" -mtime +30 -exec rm {} \; > /dev/null
find /root/backup -name "database_*" -mtime +30 -exec rm {} \; > /dev/null
