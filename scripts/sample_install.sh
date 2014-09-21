#!/bin/bash

MY_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

. ${MY_DIR}/include/path_variables.sh
 
. ${MY_DIR}/check_installed.sh
echo
echo "*******************************************************************"
echo "* путь инсталляции AGAGA существует: ${AGAGA_PATH_EXISTS}          "
echo "* зависимости PHP AGAGA установлены: ${AGAGA_PHP_DEPENDENCIES_SATISFIED} "
echo "* база данных AGAGA существует: ${AGAGA_SQL_DATABASE_EXISTS}           "
echo "*******************************************************************"
echo

read -p "Скопировать файлы AGAGA в инсталляционную директорию [yY/N]? " -n 1 -r
echo    # (optional) move to a new line
if [[ $REPLY =~ ^[Yy]$ ]]
then
    ${MY_DIR}/include/agaga/move_targetdir.sh
    ${MY_DIR}/include/agaga/symlink_captcha_dir.sh
fi

read -p "Установить зависимости модулей AGAGA PHP через Композитор [yY/N]? " -n 1 -r
echo    # (optional) move to a new line
if [[ $REPLY =~ ^[Yy]$ ]]
then
    ${MY_DIR}/include/agaga/install_php_dependecies.sh
fi

read -p "Создать схему базы данных [yY/N]? " -n 1 -r
echo    # (optional) move to a new line
if [[ $REPLY =~ ^[Yy]$ ]]
then
    ${MY_DIR}/include/db/create_schema.sh
fi


read -p "Подключить конфигурационные файлы для Asterisk AGAGA PBX [yY/N]? " -n 1 -r
echo    # (optional) move to a new line
if [[ $REPLY =~ ^[Yy]$ ]]
then
    ${MY_DIR}/include/asterisk/symlink_asterconfig.sh
fi

read -p "Исправить права доступа Unix для Asterisk [yY/N]? " -n 1 -r
echo    # (optional) move to a new line
if [[ $REPLY =~ ^[Yy]$ ]]
then
    ${MY_DIR/}include/asterisk/create_permissions.sh
fi

read -p "Скопировать конфигурацию Apache [yY/N]? " -n 1 -r
echo    # (optional) move to a new line
if [[ $REPLY =~ ^[Yy]$ ]]
then
${MY_DIR/}include/apache/bootstrap_conf.sh
${MY_DIR/}include/apache/restart_apache.sh
fi



echo Инсталляция завершена


