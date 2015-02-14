<?php
namespace serverviewer\client;

use raklib\protocol\ACK;
use raklib\protocol\ADVERTISE_SYSTEM;
use raklib\protocol\DATA_PACKET_0;
use raklib\protocol\DATA_PACKET_1;
use raklib\protocol\DATA_PACKET_2;
use raklib\protocol\DATA_PACKET_3;
use raklib\protocol\DATA_PACKET_4;
use raklib\protocol\DATA_PACKET_5;
use raklib\protocol\DATA_PACKET_6;
use raklib\protocol\DATA_PACKET_7;
use raklib\protocol\DATA_PACKET_8;
use raklib\protocol\DATA_PACKET_9;
use raklib\protocol\DATA_PACKET_A;
use raklib\protocol\DATA_PACKET_B;
use raklib\protocol\DATA_PACKET_C;
use raklib\protocol\DATA_PACKET_D;
use raklib\protocol\DATA_PACKET_E;
use raklib\protocol\DATA_PACKET_F;
use raklib\protocol\NACK;
use raklib\protocol\OPEN_CONNECTION_REPLY_1;
use raklib\protocol\OPEN_CONNECTION_REPLY_2;
use raklib\protocol\OPEN_CONNECTION_REQUEST_1;
use raklib\protocol\Packet;
use raklib\protocol\UNCONNECTED_PING;
use raklib\protocol\UNCONNECTED_PING_OPEN_CONNECTIONS;
use raklib\protocol\UNCONNECTED_PONG;
use serverviewer\client\protocol\OPEN_CONNECTION_REQUEST_2;

class StaticPacketPool{
    private static $packetPool = [];
    private static function registerPacket($id, $class){
        StaticPacketPool::$packetPool[$id] = new $class;
    }

    /**
     * @param $id
     *
     * @return Packet
     */
    static public function getPacketFromPool($id){
        if(empty(StaticPacketPool::$packetPool)) StaticPacketPool::registerPackets();
        if(isset(StaticPacketPool::$packetPool[$id])){
            return clone StaticPacketPool::$packetPool[$id];
        }

        return null;
    }
    private static function registerPackets(){
        StaticPacketPool::registerPacket(UNCONNECTED_PING::$ID, UNCONNECTED_PING::class);
        StaticPacketPool::registerPacket(UNCONNECTED_PING_OPEN_CONNECTIONS::$ID, UNCONNECTED_PING_OPEN_CONNECTIONS::class);
        StaticPacketPool::registerPacket(OPEN_CONNECTION_REQUEST_1::$ID, OPEN_CONNECTION_REQUEST_1::class);
        StaticPacketPool::registerPacket(OPEN_CONNECTION_REPLY_1::$ID, OPEN_CONNECTION_REPLY_1::class);
        StaticPacketPool::registerPacket(OPEN_CONNECTION_REQUEST_2::$ID, OPEN_CONNECTION_REQUEST_2::class);
        StaticPacketPool::registerPacket(OPEN_CONNECTION_REPLY_2::$ID, OPEN_CONNECTION_REPLY_2::class);
        StaticPacketPool::registerPacket(UNCONNECTED_PONG::$ID, UNCONNECTED_PONG::class);
        StaticPacketPool::registerPacket(ADVERTISE_SYSTEM::$ID, ADVERTISE_SYSTEM::class);
        StaticPacketPool::registerPacket(DATA_PACKET_0::$ID, DATA_PACKET_0::class);
        StaticPacketPool::registerPacket(DATA_PACKET_1::$ID, DATA_PACKET_1::class);
        StaticPacketPool::registerPacket(DATA_PACKET_2::$ID, DATA_PACKET_2::class);
        StaticPacketPool::registerPacket(DATA_PACKET_3::$ID, DATA_PACKET_3::class);
        StaticPacketPool::registerPacket(DATA_PACKET_4::$ID, DATA_PACKET_4::class);
        StaticPacketPool::registerPacket(DATA_PACKET_5::$ID, DATA_PACKET_5::class);
        StaticPacketPool::registerPacket(DATA_PACKET_6::$ID, DATA_PACKET_6::class);
        StaticPacketPool::registerPacket(DATA_PACKET_7::$ID, DATA_PACKET_7::class);
        StaticPacketPool::registerPacket(DATA_PACKET_8::$ID, DATA_PACKET_8::class);
        StaticPacketPool::registerPacket(DATA_PACKET_9::$ID, DATA_PACKET_9::class);
        StaticPacketPool::registerPacket(DATA_PACKET_A::$ID, DATA_PACKET_A::class);
        StaticPacketPool::registerPacket(DATA_PACKET_B::$ID, DATA_PACKET_B::class);
        StaticPacketPool::registerPacket(DATA_PACKET_C::$ID, DATA_PACKET_C::class);
        StaticPacketPool::registerPacket(DATA_PACKET_D::$ID, DATA_PACKET_D::class);
        StaticPacketPool::registerPacket(DATA_PACKET_E::$ID, DATA_PACKET_E::class);
        StaticPacketPool::registerPacket(DATA_PACKET_F::$ID, DATA_PACKET_F::class);
        StaticPacketPool::registerPacket(NACK::$ID, NACK::class);
        StaticPacketPool::registerPacket(ACK::$ID, ACK::class);
    }
}