<?php

/**
 * 
 *  _               _          ____  _            _   __        __             
 * | |   _   _  ___| | ___   _| __ )| | ___   ___| | _\ \      / /_ _ _ __ ___ 
 * | |  | | | |/ __| |/ / | | |  _ \| |/ _ \ / __| |/ /\ \ /\ / / _` | '__/ __|
 * | |__| |_| | (__|   <| |_| | |_) | | (_) | (__|   <  \ V  V / (_| | |  \__ \
 * |_____\__,_|\___|_|\_\\__, |____/|_|\___/ \___|_|\_\  \_/\_/ \__,_|_|  |___/
 *                       |___/
 *   Copyright 2016 Survingo
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * http://www.apache.org/licenses/LICENSE-2.0
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
*/

namespace Survingo\LuckyBlockWars\game;

use pocketmine\block\Block;
use pocketmine\Player;
use pocketmine\item\Item;
use Survingo\LuckyBlockWars\LuckyBlockWars;

class UnluckyBlocks{
  /** @var Main $plugin */
  private $plugin;
  /** @var Block $block */
  private $block;
  /** @var Player $player */
  private $player;
  
  public function __construct(LuckyBlockWars $plugin, Block $block, Player $player){
    $this->plugin = $plugin;
    $this->block = $block;
    $this->player = $player;
  }
  
  public function run(){
    switch(mt_rand(1,2)){
      case 1: (new \pocketmine\level\Explosion($this->block, mt_rand($this->plugin->getConfig()->get("min-explosion"), $this->plugin->getConfig("max-explosion"))))->explodeA();
      break;
      case 2: //do anything else
      break;
    }
  }
  
}
