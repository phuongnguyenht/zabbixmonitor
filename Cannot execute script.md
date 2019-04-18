# Cannot execute script on zabbix server
```
Remote commands are not enabled. [zabbix.php:21 → require_once() → ZBase->run() → ZBase->processRequest() → CController->run() → CControllerPopupScriptExec->doAction() → CApiWrapper->__call() → CFrontendApiWrapper->callMethod() → CApiWrapper->callMethod() → CFrontendApiWrapper->callClientMethod() → CLocalApiClient->callMethod() → CScript->execute() → CApiService::exception() in include/classes/api/services/CScript.php:616]
Cannot execute script
```
1. Fix:
```
On server client install zabbix agent, open file /etc/zabbix/zabbix_agentd.conf
EnableRemoteCommands=1
Option: EnableRemoteCommands
       Whether remote commands from Zabbix server are allowed.
       0 - not allowed
       1 - allowed
Then restart zabbix agent
systemctl restart zabbix-agent

it' ok
```
