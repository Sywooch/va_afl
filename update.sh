#!/bin/bash
wget -o /dev/null -O /dev/null http://files.va-afl.su/schedule/?type=1
wget -o /dev/null -O /dev/null http://files.va-afl.su/schedule/?type=2
wget -o /dev/null -O /dev/null http://files.va-afl.su/schedule/?type=3
wget -o /dev/null -O /dev/null http://files.va-afl.su/schedule/?type=4

ROOT_PATH=$(cd $(dirname $0) && pwd);
$ROOT_PATH/./yii flight-ops/schedule
