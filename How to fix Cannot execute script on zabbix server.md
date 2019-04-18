# How to fix Cannot execute script on zabbix server
1. Detect operating system
```
sudo: sorry, you must have a tty to run sudo
Cannot execute script

install nmap on centos:
yum install nmap -y

open file vi /etc/sudoers

comment Defaults    requiretty
and add line 
zabbix ALL=(ALL:ALL) NOPASSWD:/usr/bin/nmap

it's Ok 
```