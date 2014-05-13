#!/bin/sh

#
# this is for symlinking current project to existing ZF2 installation (presumably in /var/ZF2)
#
# !! run from the script's working dir only!!!
#
# run before running composer
#
# must be elevated to root - otherwise along with absense of /var/ZF2/vendor/zendframework 
# may result in broken link, thus failed project's installation
#
# KA
#
cd ..
rm -f vendor/zendframework
mkdir /var/ZF2
mkdir /var/ZF2/vendor
mkdir /var/ZF2/vendor/zendframework
ln -s /var/ZF2/vendor/zendframework -s `pwd`/vendor/zendframework
cd bin
echo done

