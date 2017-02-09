#!/bin/bash
path=$(dirname `readlink -f "$0"`)
proc=resque.php

queues=(singleSms groupMsg smartCache)

log_file=$path/queue.log
cd $path

start() {
    for queue in ${queues[@]};
    do
        nohup ./$proc run/index --queue=${queue} > $log_file 2>&1 &
    done
}

stop() {
    ps -ef | grep "${proc}" | grep -v grep | awk '{print $2}' | xargs kill -15
}

kill() {
    ps -ef | grep "${proc}" | grep -v grep | awk '{print $2}' | xargs kill -9
}

case "$1" in
    start)
        number=$(ps aux | grep "${proc}" | grep -v grep | wc -l)
        if [ $number -gt 0 ]
        then
            echo "queue is running. ($number workers)"
            echo "You may wanna stop them before you start."
        else
            start
        fi
    ;;

    stop)
        stop
    ;;

    kill)
        kill
    ;;

    restart)
	    stop
	    sleep 2
        rm $log_file
	    number=$(ps aux | grep ${proc} | grep -v grep | wc -l)
        if [ $number -gt 0 ]
        then
            echo "queue is running. ($number workers)"
            echo "You may wanna stop them before you start."
        else
            start
        fi
    ;;

    status)
        number=$(ps aux | grep ${proc} | grep -v grep | wc -l)
        if [ $number -gt 0 ]
        then
            echo "queue is running. ($number workers)"
        else
            echo "queue is not running."
        fi
    ;;

    *)
        echo -n "Usage: $0 {start|stop|status}"
esac
