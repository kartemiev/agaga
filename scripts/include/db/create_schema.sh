#!/bin/sh

# создаем схему БД AGAGA
postgres -U agaga -W agaga <${MY_DIR}/../sql/schema.sql