<?php

/*
 _               _          ____  _            _   __        __             
| |   _   _  ___| | ___   _| __ )| | ___   ___| | _\ \      / /_ _ _ __ ___ 
| |  | | | |/ __| |/ / | | |  _ \| |/ _ \ / __| |/ /\ \ /\ / / _` | '__/ __|
| |__| |_| | (__|   <| |_| | |_) | | (_) | (__|   <  \ V  V / (_| | |  \__ \
|_____\__,_|\___|_|\_\\__, |____/|_|\___/ \___|_|\_\  \_/\_/ \__,_|_|  |___/
                      |___/
   Copyright 2016 Survingo
   Licensed under the Apache License, Version 2.0 (the "License");
   you may not use this file except in compliance with the License.
   You may obtain a copy of the License at
       http://www.apache.org/licenses/LICENSE-2.0
   Unless required by applicable law or agreed to in writing, software
   distributed under the License is distributed on an "AS IS" BASIS,
   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
   See the License for the specific language governing permissions and
limitations under the License.
*/

namespace Survingo\LuckyBlockWars\tasks;

use pocketmine\scheduler\PluginTask;
use pocketmine\math\Vector3;
use pocketmine\tile\Sign as SignTile;
use Survingo\LuckyBlockWars\LuckyBlockWars;

class StatusSignTask extends PluginTask{
  /** @var LuckyBlockWars */
  private $plugin;
  
  public function __construct(LuckyBlockWars $plugin){
    parent::__construct($plugin);
    $this->plugin = $plugin;
  }
  
  public function onRun($currentTick){
    if($this->plugin->pos["sign-mode"]){
      $tile = $this->plugin->getServer()->getLevelByName($this->plugin->pos["sign-world"])->getTile(new Vector3($this->plugin->pos["sign-x"], $this->plugin->pos["sign-y"], $this->plugin->pos["sign-z"]));
      if($tile instanceof SignTile){
        if($this->plugin->running == true){
          $tile->setText("§l[§6L§eB§cW§f]", "§cRunning", "Players", "§1" . count($this->plugin->players) . "§7/§9" . $this->plugin->getConfig()->get("needed-players"));
          }elseif($this->plugin->running == false and count($this->plugin->reds) !== $this->plugin->getConfig()->get("needed-players")){
            $tile->setText("§l[§6L§eB§cW§f]", "§aJoin", "Players", "§1" . count($this->plugin->players) . "§7/§9" . $this->plugin->getConfig()->get("needed-players"));
            }elseif($this->plugin->running == false and count($this->plugin->players) == $this->plugin->getConfig()->get("needed-players")){
              $tile->setText("§l[§6L§eB§cW§f]", "§6Full", "Players", "§1" . count($this->plugin->players) . "§7/§9" . $this->plugin->getConfig()->get("needed-players"));
            }
      }
    }
  }
  
}
