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

namespace Survingo\LuckyBlocks\game;

use pocketmine\Player;

use Survingo\LuckyBlockWars\LuckyBlockWars;

class UnluckyBlocks{
  
  private $plugin;
  
  private $block;
  
  public function __construct(LuckyBlockWars $plugin, $block, Player $player){
    $this->block = $block;
    $this->plugin = $plugin;
    $this->block = $block;
  }
  
  public function run(){
    switch(mt_rand(1,2)){
      case 1: (new \pocketmine\level\Explosion($this->block, mt_rand($this->plugin->getConfig()->get("min-explosion"), $this->plugin->getConfig("max-explosion"))))->explodeA();
      break;
      case 2:
      break;
    }
  }
  
}
