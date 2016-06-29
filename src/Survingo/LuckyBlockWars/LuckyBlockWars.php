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

namespace Survingo\LuckyBlockWars;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use pocketmine\math\Vector3;
use pocketmine\plugin\PluginBase;

class LuckyBlockWars extends PluginBase implements Listener{
   const UNLUCKY_STUFF = array(
      $boom = new \pocketmine\level\Explosion($event->getBlock(), mt_rand($this->getConfig()->get("explosion_min"), $this->getConfig()->get("explosion_max")));
      $boom->explodeA();
      );
   const NORMAL_STUFF = array(
      
      );
   const LUCKY_STUFF = (
      
      );
   
  public function onBlockBreak(BlockBreakEvent $event){
     if($event->getBlock()->getId() == $this->getConfig()->get("luckyblock-id")){
        if($event->getPlayer()->hasPermission("lbw.use")){
           switch (mt_rand(1,3)){
              case 1: LuckyBlockWars::getRandom(LuckyBlockWars::UNLUCKY_STUFF);
              break;
              case 2: LuckyBlockWars::getRandom(LuckyBlockWars::NORMAL_STUFF);
              break;
              case 3: LuckyBlockWars::getRandom(LuckyBlockWars::LUCKY_STUFF);
              break;
           }
        }else{
           $event->getPlayer()->sendMessage($this->getConfig()->get("not_allowed"));
        }
     }
  }
 
 public static function getRandom(array $things){
    if(is_array($things)) return $things[array_rand($things, 1)];
 }
 
}
