<?php
require_once "vendor/autoload.php";
file_put_contents("lib/pocketmine/src/raklib/RakLib.php", str_replace('exit(1);', "", file_get_contents("lib/pocketmine/src/raklib/RakLib.php")));
$client = new \serverviewer\client\MCPEClient("bob");
$client->addConnection("127.0.0.1", 19132);

while(true){
    $client->tick();
    usleep(1000);
}