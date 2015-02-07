<?php
namespace serverviewer\client;


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