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

use pocketmine\block\Block;
use pocketmine\Player;
use pocketmine\item\Item;
use Survingo\LuckyBlockWars\LuckyBlockWars;

class LuckyBlocks{
  
  private $plugin;
  
  private $block;
  
  private $player;
  
  public function __construct(LuckyBlockWars $plugin, Block $block, Player $player){
    $this->plugin = $plugin;
    $this->block = $block;
    $this->player = $player;
  }
  
  public function run(){
    switch(mt_rand(1,3)){
      case 1: $this->player->getLevel()->dropItem($this->block, Item::get(Item::DIAMOND,0,1,"{display:{Name:"§b§lLucky Diamond"}}"));
      break;
      case 2: $this->player->getLevel()->dropItem($this->block, Item::get(Item::BOW,0,1,"{display:{Name:"§6§lLucky Bow"},ench:[{id:22s,lvl:1s},{id:20s,lvl:2s}]}"));
      $this->player->getLevel()->dropItem($this->block, Item::get(Item::ARROW));
      break;
      case 3: $this->player->getLevel()->dropItem($this->block, Item::get(Item::DIAMOND_HELMET,0,1,"{display:{Name:"§1Lucky Armor"},ench:[{id:4s,lvl:1s}]}"));
      $this->player->getLevel()->dropItem($this->block, Item::get(Item::DIAMOND_CHESTPLATE,0,1,"{display:{Name:"§1Lucky Armor"},ench:[{id:3s,lvl:1s}]}"));
      $this->player->getLevel()->dropItem($this->block, Item::get(Item::DIAMOND_LEGGINGS,0,1,"{display:{Name:"§1Lucky Armor"},ench:[{id:1s,lvl:1s}]}"));
      $this->player->getLevel()->dropItem($this->block, Item::get(Item::DIAMOND_BOOTS,0,1,"{display:{Name:"§1Lucky Armor"},ench:[{id:2s,lvl:4s}]}"));
      break;
    }
  }
  
}
