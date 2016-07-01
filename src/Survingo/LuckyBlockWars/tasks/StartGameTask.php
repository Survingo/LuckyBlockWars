<?php

/*
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
    foreach($this->plugin->players as $player){
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
