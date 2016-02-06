#!/bin/sh
# deploy ssh keys (id_rsa, id_rsa.pub, authorized_keys)
# @param string host name to be deployed

host=$1
if [ "$host" == "" ]; then
    echo "Arguments(hostname) is empty."
    exit 1;
fi

echo "-- check local files.";
if [ ! -f ${HOME}/.ssh/id_rsa -o ! -f ${HOME}/.ssh/id_rsa.pub ]; then
    echo "Please execute command 'ssh-keygen' on localhost."
    exit 1;
fi

ping -c 1 $host > /dev/null
if [ $? -ne 0 ]; then
    echo "Server not found"
    exit 1;
fi

echo "-- make directory .ssh"
echo "  Please input your password"
ssh $host "test -d .ssh || mkdir .ssh;"
if [ $? -ne 0 ]; then
    echo "Fail to access server: $host"
    exit 1;
fi

echo "-- scp key files"
echo "  Please input your password"
scp $HOME/.ssh/id_rsa*  $host:.ssh/
if [ $? -ne 0 ]; then
    echo "Fail to execute scp command"
    exit 1;
fi

echo "-- add key to auth file"
echo "  Please input your password"
cmd="cat .ssh/id_rsa.pub >> .ssh/authorized_keys"
cmd="$cmd && chmod 600 .ssh/id_rsa"
cmd="$cmd && chmod 600 .ssh/authorized_keys"
ssh $host "$cmd"
if [ $? -ne 0 ]; then
    echo "Fail to make the auth file"
    exit 1;
fi

echo "-- check: ls -al && ls -al .ssh"
ssh $host "ls -al && ls -al .ssh"
echo "done"
