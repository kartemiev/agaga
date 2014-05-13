#!/bin/sh
cp -R ../webui /var/www
cp -R ../agi /etc/asterisk
postgres -U agaga -W agaga <../sql/schema.sql
