<?php

namespace Survingo\LuckyBlockWars\tasks;

use pocketmine\scheduler\PluginTask;
use pocketmine\math\Vector3;
use pocketmine\tile\Sign;
use Survingo\LuckyBlockWars\LuckyBlockWars;

class StatusSignTask extends PluginTask{
  
  private $plugin;
  
  public function __construct(LuckyBlockWars $plugin){
    parent::__construct($plugin);
    $this->plugin = $plugin;
  }
  
  public function onRun($currentTick){
    if($this->plugin->cfg["sign-mode"] === true){
      $tile = $this->plugin->getServer()->getLevelByName($this->plugin->cfg["sign-world"])->getTile(new Vector3($this->plugin->cfg["sign-x"], $this->plugin->cfg["sign-y"], $this->plugin->cfg["sign-z"]));
      if($tile instanceof Sign){
        if($this->plugin->running == true){
          $tile->setText("§l[§6L§eB§cW§f]", "§cRunning", "Players", "§1" . count($this->plugin->players) . "§7/§9" . $this->plugin->cfg["needed-players"]);
          }elseif($this->plugin->running == false and count($this->plugin->reds) !== $this->plugin->cfg["needed-players"]){
            $tile->setText("§l[§6L§eB§cW§f]", "§aJoin", "Players", "§1" . count($this->plugin->players) . "§7/§9" . $this->plugin->cfg["needed-players"]);
            }elseif($this->plugin->running == false and count($this->plugin->players) == $this->plugin->cfg["needed-players"]){
              $tile->setText("§l[§6L§eB§cW§f]", "§6Full", "Players", "§1" . count($this->plugin->players) . "§7/§9" . $this->plugin->cfg["needed-players"]);
            }
      }
    }
  }
  
}
