<?php

namespace Survingo\LuckyBlockWars;

use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use Survingo\LuckyBlockWars\tasks\StartGameTask;
use Survingo\LuckyBlockWars\tasks\PopupWaitTask;

class GameManager extends PluginBase{
  
  public $running = false;
  
  public $players = array();
  
  public function startGame(array $players){
    $plugin = new LuckyBlockWars();
    if(count($this->players < 5)){
      $this->running = true;
      foreach($players as $player){
        $player->sendMessage("[LuckyBlockWars] Starting game...");
        Server::getInstance()->getScheduler()->scheduleRepeatingTask(new StartGameTask($plugin), 20);
        Server::getInstance()->getScheduler()->cancelTask($this->popupWait->getTaskId());
      }
    }else{
      $this->popupWait = Server::getInstance()->getScheduler()->scheduleRepeatingTask(new PopupWaitTask($plugin), 20);
    }
  }
  
}
