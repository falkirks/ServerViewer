<?php
namespace serverviewer\client;


use pocketmine\network\protocol\DataPacket;
use raklib\protocol\CLIENT_CONNECT_DataPacket;
use raklib\protocol\CLIENT_HANDSHAKE_DataPacket;
use raklib\protocol\OPEN_CONNECTION_REPLY_1;
use raklib\protocol\OPEN_CONNECTION_REPLY_2;
use raklib\protocol\OPEN_CONNECTION_REQUEST_1;
use raklib\protocol\OPEN_CONNECTION_REQUEST_2;
use raklib\protocol\Packet;
use raklib\protocol\SERVER_HANDSHAKE_DataPacket;
use raklib\protocol\UNCONNECTED_PONG;
use serverviewer\Tickable;

class MCPEClient implements Tickable{
    private $name;
    /** @var  ClientConnection[] */
    private $connections;
    public function __construct($name){
        $this->name = $name;
        $this->connections = [];
    }
    public function addConnection($ip, $port){
        $this->connections[] = new ClientConnection($this, $ip, $port);
    }
    public function handlePacket(ClientConnection $connection, Packet $pk){
        switch(get_class($pk)){
            case UNCONNECTED_PONG::class:
                $pk = new OPEN_CONNECTION_REQUEST_1();
                $pk->mtuSize = 1447;
                $connection->sendPacket($pk);
                break;
            case OPEN_CONNECTION_REPLY_1::class:
                $pk = new OPEN_CONNECTION_REQUEST_2();
                $pk->serverPort = $connection->getPort();
                $pk->mtuSize = 1447;
                $pk->clientID = 1;
                $connection->sendPacket($pk);
                break;
            case OPEN_CONNECTION_REPLY_2::class:
                $pk = new CLIENT_CONNECT_DataPacket();
                $pk->clientID = 1;
                $pk->session = 1;
                $connection->sendEncapsulatedPacket($pk);
                break;
            case SERVER_HANDSHAKE_DataPacket::class:
                $pk = new CLIENT_HANDSHAKE_DataPacket();
                $pk->cookie = 1;
                $pk->security = 1;
                $pk->port = $connection->getPort();
                $pk->dataArray
                break;
            default:
                print get_class($pk);
                break;
        }
    }
    public function handleDataPacket(ClientConnection $connection, DataPacket $packet){
        print get_class($packet);
    }
    /**
     * @return mixed
     */
    public function getName(){
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name){
        $this->name = $name;
    }
    public function tick(){
        foreach($this->connections as $connection){
            $connection->tick();
        }
    }

}