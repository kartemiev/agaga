#!/bin/bash

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
