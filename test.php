<?php
require_once "vendor/autoload.php";
file_put_contents("lib/pocketmine/src/raklib/RakLib.php", str_replace('exit(1);', "", file_get_contents("lib/pocketmine/src/raklib/RakLib.php")));
$con = new \serverviewer\client\ClientConnection(new \serverviewer\client\MCPEClient("bob"), "127.0.0.1", "19132");
$con->sendPacket(new \raklib\protocol\UNCONNECTED_PING());
while(true){
    $buffer = $con->receivePacket();
    if($buffer != null)
    var_dump($buffer);
}