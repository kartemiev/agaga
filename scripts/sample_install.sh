#!/bin/sh


MY_DIR=$(dirname $(readlink -f $0))
$MY_DIR/include/path_variables.sh

# создаем схему БД AGAGA
postgres -U agaga -W agaga <${MY_DIR}/../sql/schema.sql

# копируем AGAGA в директорию инсталляции
mkdir ${AGAGA_INSTALL_DIR}
cp -r ../* ${AGAGA_INSTALL_DIR}
chown -R asterisk:asterisk ${AGAGA_INSTALL_DIR}/agi
chown www-data:www-data ${AGAGA_INSTALL_DIR}/webui


# создаем директории необходимые для функционирования Asterisk
sh ../agi/install/asterisk_create_directories_permissions.sh


# устанавливаем модули-зависимости для основного ПО через композитор
# модуль AGI
cd ${AGAGA_INSTALL_DIR}/agi
php composer.phar install
# модуль веб-интерфейса
cd ${AGAGA_INSTALL_DIR}/webui
php composer.phar install
# модуль cli/cron
cd ${AGAGA_INSTALL_DIR}/cli
php composer.phar install

$MY_DIR/include/symlink_asterconfig.sh
