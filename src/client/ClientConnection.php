<?php
namespace serverviewer\client;

use raklib\protocol\EncapsulatedPacket;
use raklib\protocol\Packet;
use raklib\server\UDPServerSocket;
use serverviewer\Tickable;

class ClientConnection extends UDPServerSocket implements Tickable{
    const START_PORT = 49152;
    private static $instanceId = 0;

    /** @var  MCPEClient */
    private $client;
    private $ip;
    private $port;

    public function __construct(MCPEClient $client, $ip, $port){
        $this->socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        //socket_set_option($this->socket, SOL_SOCKET, SO_BROADCAST, 1); //Allow sending broadcast messages
        if(@socket_bind($this->socket, "0.0.0.0", ClientConnection::START_PORT + ClientConnection::$instanceId) === true){
            socket_set_option($this->socket, SOL_SOCKET, SO_REUSEADDR, 0);
            $this->setSendBuffer(1024 * 1024 * 8)->setRecvBuffer(1024 * 1024 * 8);
        }
        socket_set_nonblock($this->socket);
        ClientConnection::$instanceId++;

        $this->client = $client;
        $this->ip = $ip;
        $this->port = $port;
    }
    public function sendPacket(Packet $packet){
        $packet->encode();
        return $this->writePacket($packet->buffer, $this->ip, $this->port);
    }
    public function receivePacket(){
        $this->readPacket($buffer, $this->ip, $this->port);
        if(($packet = StaticPacketPool::getPacketFromPool(ord($buffer{0}))) !== null){
            $packet->buffer = $buffer;
            $packet->decode();
            return $packet;
        }
        return $buffer;
    }
    public function tick(){

    }
}