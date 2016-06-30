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
use pocketmine\utils\Config;

class LuckyBlockWars extends PluginBase implements Listener{
   
  public function onEnable(){
     $this->getServer()->getLogger()->info("[" . $this->getDescription()->getName() . "] Enabling " . $this->getDescription()->getFullName() . " by Survingo...");
     $this->saveResource("config.yml");//$this->saveDefaultConfig();
     $cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
     $this->cfg = $cfg->getAll();
  }
  
  public function onBlockBreak(BlockBreakEvent $event){
     if($event->getBlock()->getId() == $this->cfg["luckyblock-id"]){
        if($event->getPlayer()->hasPermission("lucky-block-wars.use")){
           switch (mt_rand(1,3)){
              case 1: $this->getRandom($this->unluckyBlockStuff($event->getBlock()));
              break;
              case 2: $this->getRandom($this->normalBlockStuff($event->getBlock()));
              break;
              case 3: $this->getRandom($this->luckyBlockStuff($event->getBlock()));
              break;
           }
        }else{
           $event->getPlayer()->sendMessage($this->cfg["not_allowed"]);
        }
     }
  }
 
 public function getRandom(array $things){
    if(is_array($things)) return $things[array_rand($things, 1)];
 }
 
 public function unluckyBlockStuff($block){
    return array(
       $boom = new \pocketmine\level\Explosion($block, mt_rand($this->cfg["explosion_min"], $this->cfg["explosion_max"]));
       $boom->explodeA();
 );}
 
 public function normalBlockStuff($block){
    return array(
       //$test->test();
 );}
 
 public function luckyBlockStuff($block){
    return array(
       //$test->test();
 );}
 
}
