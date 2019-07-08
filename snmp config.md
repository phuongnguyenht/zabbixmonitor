# Set Up snmp on server client 
```
snmpwalk -v 2c -c wap@123 10.84.73.8

snmpwalk -v 2c -c wap@123 10.84.73.8 | grep "IF-MIB::ifInOctets.3"
IF-MIB::ifInOctets.3 = Counter32: 0
snmpget -v 2c -c wap@123 -On 10.84.73.8 IF-MIB::ifInOctets.3


[root@adm1 ~]# snmpwalk -v 2c -c wap@123 10.84.73.8 | grep "IF-MIB::ifInOctets.3"
IF-MIB::ifInOctets.3 = Counter32: 0
HOST-RESOURCES-MIB::hrSWRunParameters.4750 = STRING: "IF-MIB::ifInOctets.3"
[root@adm1 ~]# snmpget -v 2c -c wap@123 -On 10.84.73.8 IF-MIB::ifInOctets.3
.1.3.6.1.2.1.2.2.1.10.3 = Counter32: 0


https://www.zabbix.com/documentation/4.0/manual/config/items/itemtypes/snmp


/usr/lib/zabbix/alertscripts
```