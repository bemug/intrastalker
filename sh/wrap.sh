#!/bin/bash

HOST="FTP_ADDR"
USER="FTP_USER"
PASS="FTP_PASS"

while true
do
    echo "Scanning on `date`"
    ./pimagmp.sh > data.log
    #here goes the ftp send
    ftp -in $HOST <<EOF
    user $USER $PASS
    cd www/stalker/
    put data.log
    bye
EOF
    echo "Sleeping"
    sleep 300
done
