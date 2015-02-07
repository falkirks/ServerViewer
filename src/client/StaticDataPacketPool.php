<?php

namespace serverviewer\client;


use pocketmine\network\protocol\AddEntityPacket;
use pocketmine\network\protocol\AddItemEntityPacket;
use pocketmine\network\protocol\AddMobPacket;
use pocketmine\network\protocol\AddPaintingPacket;
use pocketmine\network\protocol\AddPlayerPacket;
use pocketmine\network\protocol\AdventureSettingsPacket;
use pocketmine\network\protocol\AnimatePacket;
use pocketmine\network\protocol\ChatPacket;
use pocketmine\network\protocol\ContainerClosePacket;
use pocketmine\network\protocol\ContainerOpenPacket;
use pocketmine\network\protocol\ContainerSetContentPacket;
use pocketmine\network\protocol\ContainerSetDataPacket;
use pocketmine\network\protocol\ContainerSetSlotPacket;
use pocketmine\network\protocol\DropItemPacket;
use pocketmine\network\protocol\EntityDataPacket;
use pocketmine\network\protocol\EntityEventPacket;
use pocketmine\network\protocol\ExplodePacket;
use pocketmine\network\protocol\HurtArmorPacket;
use pocketmine\network\protocol\InteractPacket;
use pocketmine\network\protocol\LevelEventPacket;
use pocketmine\network\protocol\LoginPacket;
use pocketmine\network\protocol\LoginStatusPacket;
use pocketmine\network\protocol\MessagePacket;
use pocketmine\network\protocol\MoveEntityPacket;
use pocketmine\network\protocol\MovePlayerPacket;
use pocketmine\network\protocol\PlayerActionPacket;
use pocketmine\network\protocol\PlayerArmorEquipmentPacket;
use pocketmine\network\protocol\PlayerEquipmentPacket;
use pocketmine\network\protocol\RemoveBlockPacket;
use pocketmine\network\protocol\RemoveEntityPacket;
use pocketmine\network\protocol\RemovePlayerPacket;
use pocketmine\network\protocol\RespawnPacket;
use pocketmine\network\protocol\RotateHeadPacket;
use pocketmine\network\protocol\SendInventoryPacket;
use pocketmine\network\protocol\SetDifficultyPacket;
use pocketmine\network\protocol\SetEntityDataPacket;
use pocketmine\network\protocol\SetEntityMotionPacket;
use pocketmine\network\protocol\SetHealthPacket;
use pocketmine\network\protocol\SetSpawnPositionPacket;
use pocketmine\network\protocol\SetTimePacket;
use pocketmine\network\protocol\StartGamePacket;
use pocketmine\network\protocol\TakeItemEntityPacket;
use pocketmine\network\protocol\TileEventPacket;
use pocketmine\network\protocol\UnknownPacket;
use pocketmine\network\protocol\Info as ProtocolInfo;
use pocketmine\network\protocol\UnloadChunkPacket;
use pocketmine\network\protocol\UpdateBlockPacket;
use pocketmine\network\protocol\UseItemPacket;

class StaticDataPacketPool {
    private static $packetPool = [];

    private static function registerPacket($id, $class){
        StaticDataPacketPool::$packetPool[$id] = $class;
    }

    /**
     * @param $id
     *
     * @return DataPacket
     */
    public static function getPacketFromPool($id){
        if(empty(StaticDataPacketPool::$packetPool)) StaticDataPacketPool::registerPackets();

        /** @var DataPacket $class */
        $class = StaticDataPacketPool::$packetPool[$id];
        if($class !== null){
            return new $class;
        }
        return null;
    }

    private static function registerPackets(){
        StaticDataPacketPool::$packetPool = new \SplFixedArray(256);

        StaticDataPacketPool::registerPacket(ProtocolInfo::LOGIN_PACKET, LoginPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::LOGIN_STATUS_PACKET, LoginStatusPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::MESSAGE_PACKET, MessagePacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::SET_TIME_PACKET, SetTimePacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::START_GAME_PACKET, StartGamePacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::ADD_MOB_PACKET, AddMobPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::ADD_PLAYER_PACKET, AddPlayerPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::REMOVE_PLAYER_PACKET, RemovePlayerPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::ADD_ENTITY_PACKET, AddEntityPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::REMOVE_ENTITY_PACKET, RemoveEntityPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::ADD_ITEM_ENTITY_PACKET, AddItemEntityPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::TAKE_ITEM_ENTITY_PACKET, TakeItemEntityPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::MOVE_ENTITY_PACKET, MoveEntityPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::ROTATE_HEAD_PACKET, RotateHeadPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::MOVE_PLAYER_PACKET, MovePlayerPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::REMOVE_BLOCK_PACKET, RemoveBlockPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::UPDATE_BLOCK_PACKET, UpdateBlockPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::ADD_PAINTING_PACKET, AddPaintingPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::EXPLODE_PACKET, ExplodePacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::LEVEL_EVENT_PACKET, LevelEventPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::TILE_EVENT_PACKET, TileEventPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::ENTITY_EVENT_PACKET, EntityEventPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::PLAYER_EQUIPMENT_PACKET, PlayerEquipmentPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::PLAYER_ARMOR_EQUIPMENT_PACKET, PlayerArmorEquipmentPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::INTERACT_PACKET, InteractPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::USE_ITEM_PACKET, UseItemPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::PLAYER_ACTION_PACKET, PlayerActionPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::HURT_ARMOR_PACKET, HurtArmorPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::SET_ENTITY_DATA_PACKET, SetEntityDataPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::SET_ENTITY_MOTION_PACKET, SetEntityMotionPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::SET_HEALTH_PACKET, SetHealthPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::SET_SPAWN_POSITION_PACKET, SetSpawnPositionPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::ANIMATE_PACKET, AnimatePacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::RESPAWN_PACKET, RespawnPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::SEND_INVENTORY_PACKET, SendInventoryPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::DROP_ITEM_PACKET, DropItemPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::CONTAINER_OPEN_PACKET, ContainerOpenPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::CONTAINER_CLOSE_PACKET, ContainerClosePacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::CONTAINER_SET_SLOT_PACKET, ContainerSetSlotPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::CONTAINER_SET_DATA_PACKET, ContainerSetDataPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::CONTAINER_SET_CONTENT_PACKET, ContainerSetContentPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::CHAT_PACKET, ChatPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::ADVENTURE_SETTINGS_PACKET, AdventureSettingsPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::ENTITY_DATA_PACKET, EntityDataPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::UNLOAD_CHUNK_PACKET, UnloadChunkPacket::class);
        StaticDataPacketPool::registerPacket(ProtocolInfo::SET_DIFFICULTY_PACKET, SetDifficultyPacket::class);
    }

    public static function getPacket($buffer){
        $pid = ord($buffer{0});

        if(($data = StaticDataPacketPool::getPacketFromPool($pid)) === null){
            $data = new UnknownPacket();
            $data->packetID = $pid;
        }
        $data->setBuffer(substr($buffer, 1));

        return $data;
    }
}