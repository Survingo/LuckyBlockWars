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
use Survingo\LuckyBlockWars\LuckyBlockWars;

class WaitPopupTask extends PluginTask{
  /** @var LuckyBlockWars */
  private $plugin;
  
  public function __construct(LuckyBlockWars $plugin){
    parent::__construct($plugin);
    $this->plugin = $plugin;
  }
  
  public function onRun($currentTick){
    foreach($this->plugin->getServer()->getPlayer($this->plugin->players) as $player){
      $player->sendPopup($this->plugin->cfg["wait-popup"]);
    }
  }
  
}
