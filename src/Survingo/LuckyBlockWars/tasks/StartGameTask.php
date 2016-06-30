<?php

namespace Survingo\LuckyBlockWars\tasks;

use pocketmine\scheduler\PluginTask;
use pocketmine\scheduler\ServerScheduler;
use Survingo\LuckyBlockWars\LuckyBlockWars;

class StartGameTask extends PluginTask{
  
  private $plugin;
  
  public $seconds = 20;
  
  public function __construct(LuckyBlockWars $plugin){
    parent::__construct($plugin);
    $this->plugin = $plugin;
  }
  
  public function onRun($currentTick){
    $this->seconds -= 1;
    foreach($this->plugin->getPlayersInGame() as $player){
      $player->sendPopup("§eLucky Block Wars will start in §6{$this->seconds} §e" . ($this->seconds <=1 ? "second" : "seconds"));
      if($this->seconds == 1){
        $player->teleport(new Vector3($this->plugin->cfg["join_x"], $this->plugin->cfg["join_y"], $this->plugin->cfg["join_z"]));
        $this->plugin->running = true;
        $this->seconds = 20;
        Tasks::cancelTask($this->getTaskId());
      }
    }
  }
  
}
