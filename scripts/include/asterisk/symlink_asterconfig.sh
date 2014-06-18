#!/bin/bash

$MY_DIR/include/path_variables.sh

rm -rf ${ASTERISK_CONFIG_DIR}/*                                    # удаляем файлы примеров конфигурации Астериска, оставшиеся после начальной инсталляции Астериск

ln -s ${AGAGA_INSTALL_DIR}/asterisk/acl.conf ${ASTERISK_CONFIG_DIR}/acl.conf
ln -s ${AGAGA_INSTALL_DIR}/asterisk/asterisk.conf ${ASTERISK_CONFIG_DIR}/asterisk.conf
ln -s ${AGAGA_INSTALL_DIR}/asterisk/cdr.conf ${ASTERISK_CONFIG_DIR}/cdr.conf
ln -s ${AGAGA_INSTALL_DIR}/asterisk/cdr_pgsql.conf ${ASTERISK_CONFIG_DIR}/cdr_pgsql.conf
ln -s ${AGAGA_INSTALL_DIR}/asterisk/cel.conf ${ASTERISK_CONFIG_DIR}/cel.conf
ln -s ${AGAGA_INSTALL_DIR}/asterisk/cel_pgsql.conf ${ASTERISK_CONFIG_DIR}/cel_pgsql.conf
ln -s ${AGAGA_INSTALL_DIR}/asterisk/cli.conf ${ASTERISK_CONFIG_DIR}/cli.conf
ln -s ${AGAGA_INSTALL_DIR}/asterisk/confbridge.conf ${ASTERISK_CONFIG_DIR}/confbridge.conf
ln -s ${AGAGA_INSTALL_DIR}/asterisk/extconfig.conf ${ASTERISK_CONFIG_DIR}/extconfig.conf
ln -s ${AGAGA_INSTALL_DIR}/asterisk/extensions.conf ${ASTERISK_CONFIG_DIR}/extensions.conf
ln -s ${AGAGA_INSTALL_DIR}/asterisk/features.conf ${ASTERISK_CONFIG_DIR}/features.conf
ln -s ${AGAGA_INSTALL_DIR}/asterisk/indications.conf ${ASTERISK_CONFIG_DIR}/indications.conf
ln -s ${AGAGA_INSTALL_DIR}/asterisk/logger.conf ${ASTERISK_CONFIG_DIR}/logger.conf
ln -s ${AGAGA_INSTALL_DIR}/asterisk/manager.conf ${ASTERISK_CONFIG_DIR}/manager.conf
ln -s ${AGAGA_INSTALL_DIR}/asterisk/modules.conf ${ASTERISK_CONFIG_DIR}/modules.conf
ln -s ${AGAGA_INSTALL_DIR}/asterisk/musiconhold.conf ${ASTERISK_CONFIG_DIR}/musiconhold.conf
ln -s ${AGAGA_INSTALL_DIR}/asterisk/queuerules.conf ${ASTERISK_CONFIG_DIR}/queuerules.conf
ln -s ${AGAGA_INSTALL_DIR}/asterisk/res_fax.conf ${ASTERISK_CONFIG_DIR}/res_fax.conf
ln -s ${AGAGA_INSTALL_DIR}/asterisk/res_pgsql.conf ${ASTERISK_CONFIG_DIR}/res_pgsql.conf
ln -s ${AGAGA_INSTALL_DIR}/asterisk/rtp.conf ${ASTERISK_CONFIG_DIR}/rtp.conf
ln -s ${AGAGA_INSTALL_DIR}/asterisk/say.conf ${ASTERISK_CONFIG_DIR}/say.conf
ln -s ${AGAGA_INSTALL_DIR}/asterisk/sip.conf ${ASTERISK_CONFIG_DIR}/sip.conf
ln -s ${AGAGA_INSTALL_DIR}/asterisk/udptl.conf ${ASTERISK_CONFIG_DIR}/udptl.conf
ln -s ${AGAGA_INSTALL_DIR}/asterisk/voicemail.conf ${ASTERISK_CONFIG_DIR}/voicemail.conf

touch ${ASTERISK_CONFIG_DIR}/sip_custom.conf
touch ${ASTERISK_CONFIG_DIR}/extensions_custom.conf
touch ${ASTERISK_CONFIG_DIR}/voicemail_custom.conf
touch ${ASTERISK_CONFIG_DIR}/manager_custom.conf
touch ${ASTERISK_CONFIG_DIR}/features_custom.conf

