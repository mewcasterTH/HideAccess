<?php
namespace hideaccess;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;
class Main extends PluginBase implements Listener
{
    public function onEnable()
    {
        $this->getServer()->getLogger()->info("HideExcess By HeavenPE started");
        $this->getServer()->getLogger()->info("Discord.HeavenPE.Cf");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
    public function onSendPacket(DataPacketSendEvent $event){
        $packet = $event->getPacket();
        $player = $event->getPlayer();
        if($packet instanceof AvailableCommandsPacket){
            $data = [];
            foreach($this->plugin->getServer()->getCommandMap()->getCommands() as $command){
                if($player->hasPermission($command->getPermission())){
                    if(count($cmdData = $command->generateCustomCommandData($player)) > 0){
                        $data[$command->getName()]["versions"][0] = $cmdData;
                    }
                }
            }
            if(count($data) > 0){
                $packet->commands = json_encode($data);
            }
        }
    }
}
