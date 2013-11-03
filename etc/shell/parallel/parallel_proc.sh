#!/bin/sh
echo "start: $1"
rnd=`od -vAn -N4 -tu4 < /dev/random`
rnd=`expr $rnd % 10`
sleep $rnd
echo "finish: $1"
