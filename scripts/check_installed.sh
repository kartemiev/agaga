#!/bin/bash

. $MY_DIR/include/path_variables.sh


if [ -d "$AGAGA_INSTALL_DIR" ]; then
AGAGA_PATH_EXISTS="yes";
else
AGAGA_PATH_EXISTS="no";
fi

. $MY_DIR/include/agaga/check_php_dependencies_installed.sh


psql postgres -tAc "SELECT 1 FROM pg_roles WHERE rolname='agaga'"   2>/dev/null | grep -q 1


psql -lqt -U agaga   2>/dev/null | cut -d \| -f 1 | grep -w agaga

rc=$?
if [[ $rc != 0 ]] ; then
AGAGA_SQL_DATABASE_EXISTS="no"
else
AGAGA_SQL_DATABASE_EXISTS="yes"
fi
