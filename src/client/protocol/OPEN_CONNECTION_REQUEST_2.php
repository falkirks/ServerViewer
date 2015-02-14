<?php
namespace serverviewer\client\protocol;

use raklib\RakLib;

class OPEN_CONNECTION_REQUEST_2 extends \raklib\protocol\OPEN_CONNECTION_REQUEST_2{
    public function encode(){
        $this->buffer = chr(static::$ID);
        $this->put(RakLib::MAGIC);
        $this->putByte("4");
        $this->put("3f57febe");
        $this->putShort($this->serverPort);
        $this->putShort($this->mtuSize);
        $this->putLong($this->clientID);
    }

}