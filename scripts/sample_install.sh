#!/bin/sh


MY_DIR=$(dirname $(readlink -f $0))
$MY_DIR/include/path_variables.sh


${MY_DIR}/include/agaga/move_targetdir.sh
${MY_DIR}/include/agaga/install_php_dependecies.sh
${MY_DIR}/include/db/create_schema.sh
${MY_DIR}/include/asterisk/symlink_asterconfig.sh
${MY_DIR/}include/asterisk/create_permissions.sh
${MY_DIR}/include/apache/create_permissions.sh

