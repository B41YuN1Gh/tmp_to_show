GatewayWorker's repository is  https://github.com/walkor/GatewayWorker. The bug is fixed in the version 3.1.0.  You can download a demo from http://www.workerman.net/download/GatewayWorker.zip which is still using the version before 3.1.0 and replace the 127.0.0.1 in /ROOT_PATH/Applications/YourApp/start_register.php to 0.0.0.0, which was the default configuration before we reported the bug to them.Make sure that the version of php is later than 8.1 with extension pcntl and posix, and then,run `php start.php start` in the root dictionary to start GatewayWorker.

When the GatewayWorker runs,it expose the port 1238 as registry for others register as a worker or gateway. If an application registers as a gateway,it can send messages using custom protocol to all workers.According to the implementation of the protocol, part of the message will be unserialized,which lead to delete arbitrary file in the server.

You can just copy gateway.php and poc.php to the GatewayWorker's root path and run `php gateway.php start`, you will see the `/tmp/file_to_delete` deleted

