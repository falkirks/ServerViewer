<?php
namespace serverviewer\client\protocol;

class LoginStatusPacket extends \pocketmine\network\protocol\LoginStatusPacket{
    public function decode(){
        parent::decode();
        $this->status = $this->getInt();
    }

}