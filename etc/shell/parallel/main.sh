#!/bin/sh
readonly PARALLELS=5
readonly COMMAND="./parallel_proc.sh"
readonly DATA_DIR="./data"

for i in `find $DATA_DIR -type f -name "*.dat"`
do
    while [ `ps aux |grep "$COMMAND" |grep -v "grep"| wc -l` -ge $PARALLELS ]
    do
        sleep 1
    done

    $COMMAND $i &
done
wait
