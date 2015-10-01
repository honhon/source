#!/bin/sh

/sbin/iptables -P INPUT DROP
/sbin/iptables -P FORWARD DROP
/sbin/iptables -P OUTPUT ACCEPT

/sbin/iptables -F

/sbin/iptables -A INPUT -p icmp -j ACCEPT
/sbin/iptables -A INPUT -i lo -j ACCEPT

/sbin/iptables -A INPUT -p tcp --dport 80 -j ACCEPT
/sbin/iptables -A INPUT -p tcp --dport 443 -j ACCEPT
/sbin/iptables -A INPUT -s 192.168.*.0/255.255.255.0 -p tcp --dport 22 -j ACCEPT
/sbin/iptables -A INPUT -s 192.168.*.0/255.255.255.0 -p tcp --dport 25 -j ACCEPT
/sbin/iptables -A INPUT -s 192.168.*.0/255.255.255.0 -p tcp --dport 161 -j ACCEPT
/sbin/iptables -A INPUT -s 192.168.*.0/255.255.255.0 -p udp --dport 161 -j ACCEPT
/sbin/iptables -A INPUT -s 192.168.*.0/255.255.255.0 -p tcp --dport 162 -j ACCEPT
/sbin/iptables -A INPUT -s 192.168.*.0/255.255.255.0 -p udp --dport 162 -j ACCEPT
/sbin/iptables -A INPUT -s 192.168.*.0/255.255.255.0 -p tcp --dport 5432 -j ACCEPT
/sbin/iptables -A INPUT -s 192.168.*.0/255.255.255.0 -p tcp --dport 8080 -j ACCEPT
/sbin/iptables -A INPUT -s 192.168.*.0/255.255.255.0 -p tcp --dport 10000 -j ACCEPT

/sbin/iptables -A INPUT -m state --state ESTABLISHED,RELATED -j ACCEPT

/sbin/iptables-save