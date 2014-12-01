#!/bin/bash

DIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )

pg_dump agaga -U agaga  --schema-only    -W >$DIR/schema.sql
pg_dump agaga -U agaga  --data-only  -t directions -t functions -t user_role  -W >>$DIR/schema.sql
