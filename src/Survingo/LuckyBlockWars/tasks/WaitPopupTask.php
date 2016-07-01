<?php

namespace Survingo\LuckyBlockWars\tasks;

use pocketmine\scheduler\PluginTask;
use Survingo\LuckyBlockWars\LuckyBlockWars;

class WaitPopupTask extends PluginTask{
  
  private $plugin;
  
  public function __construct(LuckyBlockWars $plugin){
    parent::__construct($plugin);
    $this->plugin $plugin;
  }
  
  public function onRun($currentTick){
    foreach($this->plugin->getPlayersInGame() as $player){
      $this->plugin->getServer()->getPlayer($player)->sendPopup($this->plugin->cfg["wait-popup"]);
    }
  }
  
}
