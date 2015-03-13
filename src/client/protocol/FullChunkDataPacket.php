<?php
namespace serverviewer\client\protocol;

class FullChunkDataPacket extends \pocketmine\network\protocol\FullChunkDataPacket{
    public function decode(){
        //print bin2hex($this->buffer) . "\n";

        //$this->setBuffer(zlib_decode(substr($this->getBuffer(),10,-8)));
    }
}