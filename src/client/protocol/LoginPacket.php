<?php
namespace serverviewer\client\protocol;

class LoginPacket extends \pocketmine\network\protocol\LoginPacket{
    public function encode(){
        parent::encode();
        $this->reset();
        $this->putString($this->username);
        $this->putInt($this->protocol1);
        $this->putInt($this->protocol2);
        $this->putInt($this->clientId);
        $this->putString($this->loginData);
    }
}