#!/bin/sh
export ZF2_PATH=../../..

../../../vendor/phpunit/phpunit/phpunit.php $1 $2
