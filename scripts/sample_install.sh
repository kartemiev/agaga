#!/bin/sh

# создаем схему БД AGAGA
postgres -U agaga -W agaga <../sql/schema.sql

# копируем AGAGA в директорию инсталляции
mkdir /usr/local/agaga
cp -r ../* /usr/local/agaga
ln -s /usr/local/agaga/agi /etc/asterisk/agi
ln -s /usr/local/agaga/webui /var/www/agaga/webui


# создаем директории необходимые для функционирования Asterisk
sh ../agi/install/asterisk_create_directories_permissions.sh


# устанавливаем модули-зависимости для основного ПО через композитор
# модуль AGI
cd /etc/asterisk/agi
php composer.phar install
# модуль веб-интерфейса
cd /var/www/agaga/webui
php composer.phar install
# модуль cli/cron
cd /usr/local/agaga/cli
php composer.phar install

