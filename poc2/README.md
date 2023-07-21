The repository of workerman-chat is https://github.com/walkor/workerman-chat which is based on GatewayWorker.You can just clone it into your server and run `composer install` to install it.After we report the bug to them,they just change the registry's address to 127.0.0.1 instead of 0.0.0.0.The version of GatewayWorker is still before the bersion 3.1.0，which will also lead to the bug.

The reason for the bug is same to GatewayWorker and because of the introduction of third-party package `revolt`, we figured out  how to execute command in the server.


First,you should run `php start.php start` on the root path of woorkerman-chat.And then copy gateway.php and poc.php to the workerman-chat's root path and run php gateway.php start, you will see the command `ls` is executed in the console of `php start.php start`
