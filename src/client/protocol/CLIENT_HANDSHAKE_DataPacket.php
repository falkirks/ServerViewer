<?php
namespace serverviewer\client\protocol;

class CLIENT_HANDSHAKE_DataPacket extends \raklib\protocol\CLIENT_HANDSHAKE_DataPacket{
    public function encode(){
        parent::encode();
        $this->put($this->cookie);
        $this->putByte($this->security);
        $this->putShort($this->port);
        $this->putByte("3");
        $this->put("\xf5\xff\xff");
        $this->putDataArray(array_fill(0, 9, 1));
        $this->put($this->timestamp);
        $this->putLong($this->session2);
        $this->putLong($this->session);
    }
    private function putDataArray(array $data = []){
        foreach($data as $v){
            $this->putTriad(strlen($v));
            $this->put($v);
        }
    }

}