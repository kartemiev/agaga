#!/bin/bash

cp ${AGAGA_INSTALL_DIR}/scripts/include/apache/include/agaga.local.conf ${APACHE_CONFIG_DIR}/sites-available
ln -s {APACHE_CONFIG_DIR}/sites-available/agaga.local.conf {APACHE_CONFIG_DIR}/sites-enabled/agaga.local.conf
