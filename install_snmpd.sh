#!/bin/bash
# Description: auto install snmpd and config 
# Author: Phuongnguyen

yum -y install net-snmp net-snmp-utils
file="/etc/snmp/snmpd.conf"
if [ -f "$file" ]
then
	echo "$file found."
	mv /etc/snmp/snmpd.conf /etc/snmp/snmpd.conf.orig
	touch /etc/snmp/snmpd.conf
	echo "rwcommunity monitoring
	proc httpd
	proc php-fpm
	disk /
	disk /opt
	disk /home
	disk /root/myswapfile
	disk /usr/share
	disk /var/spool
	" > /etc/snmp/snmpd.conf
	systemctl restart snmpd
else
	echo "$file not found."
fi
