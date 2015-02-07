<?php
namespace serverviewer\client;

use raklib\protocol\ACK;
use raklib\protocol\DATA_PACKET_0;
use raklib\protocol\DataPacket;
use raklib\protocol\EncapsulatedPacket;
use raklib\protocol\Packet;
use raklib\protocol\SERVER_HANDSHAKE_DataPacket;
use raklib\protocol\UNCONNECTED_PING;
use raklib\server\UDPServerSocket;
use serverviewer\Tickable;

class ClientConnection extends UDPServerSocket implements Tickable{
    const START_PORT = 49152;
    private static $instanceId = 0;

    /** @var  MCPEClient */
    private $client;
    private $ip;
    private $port;

    private $sequenceNumber;
    private $ackQueue;

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
        $this->sequenceNumber = 0;
        $this->ackQueue = [];
        $this->sendPacket(new UNCONNECTED_PING()); // Initiate connection
    }
    public function sendPacket(Packet $packet){
        $packet->encode();
        return $this->writePacket($packet->buffer, $this->ip, $this->port);
    }
    public function sendEncapsulatedPacket(Packet $packet){
        $packet->encode();
        $encapsulated = new EncapsulatedPacket();
        $encapsulated->reliability = 0;
        $encapsulated->buffer = $packet->buffer;

        $sendPacket = new DATA_PACKET_0();
        $sendPacket->seqNumber = $this->sequenceNumber++;
        $sendPacket->packets[] = $encapsulated->toBinary();

        return $this->sendPacket($sendPacket);
    }
    public function receivePacket(){
        $this->readPacket($buffer, $this->ip, $this->port);
        if(($packet = StaticPacketPool::getPacketFromPool(ord($buffer{0}))) !== null){
            $packet->buffer = $buffer;
            $packet->decode();
            if($packet instanceof DATA_PACKET_0){
                $this->ackQueue[$packet->seqNumber] = $packet->seqNumber;
            }
            return $packet;
        }
        return $buffer;
    }
    public function tick(){
        if(($pk = $this->receivePacket()) instanceof Packet){
            if($pk instanceof DataPacket){
                foreach($pk->packets as $pk){
                    $id = ord($pk->buffer{0});
                    if(SERVER_HANDSHAKE_DataPacket::$ID === $id){
                        $new = new SERVER_HANDSHAKE_DataPacket();
                        $new->buffer = $pk->buffer;
                        $new->decode();
                        $this->client->handlePacket($this, $new);
                    }
                    else {
                        $new = StaticDataPacketPool::getPacket($pk->buffer);
                        $new->decode();
                        $this->client->handleDataPacket($this, $new);
                    }
                }
            }
            else {
                $this->client->handlePacket($this, $pk);
            }
        }
        if(count($this->ackQueue) > 0){
            $ack = new ACK();
            $ack->packets = $this->ackQueue;
            $this->sendPacket($ack);
            $this->ackQueue = [];
        }
    }

    /**
     * @return MCPEClient
     */
    public function getClient(){
        return $this->client;
    }

    /**
     * @return int
     */
    public function getIp(){
        return $this->ip;
    }

    /**
     * @return string
     */
    public function getPort(){
        return $this->port;
    }

}