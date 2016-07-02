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
use pocketmine\event\block\SignChangeEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\Listener;

class EventManager implements Listener{
  /** @var LuckyBlockWars */
  private $plugin;
  
  public function __construct(LuckyBlockWars $plugin){
    $this->plugin = $plugin;
  }
  
  public function onBlockBreak(BlockBreakEvent $event){
     if($event->getBlock()->getId() == $this->cfg["luckyblock-id"]){
        if($this->running === true){
           if($event->getPlayer()->hasPermission("lbw.game.use")){
              switch (mt_rand(1,3)){
                 case 1: $this->getRandom($this->unluckyBlockStuff($event->getBlock()));
                 break;
                 case 2: $this->getRandom($this->normalBlockStuff($event->getBlock()));
                 break;
                 case 3: $this->getRandom($this->luckyBlockStuff($event->getBlock()));
                 break;
              }
           }else{
              $event->setCancelled(true);
              $event->getPlayer()->sendMessage($this->cfg["not-allowed-to-use-luckyblock"]);
           }
        }else{
           $event->getPlayer()->sendMessage($this->cfg["game-is-not-running"]);
        }
     }
  }
  
  public function onSignChange(SignChangeEvent $event){
    if($event->getLine(0) == "[LBW]" or $event->getLine(0) == "[LuckyBlock]" or $event->getLine(0) == "/lbw join"){
       if($event->getPlayer()->hasPermission("lbw.game.create-signs")){
          $this->getConfig()->set("sign-x", $event->getBlock()->getX());
          $this->getConfig()->save();
          $this->getConfig()->set("sign-y", $event->getBlock()->getY());
          $this->getConfig()->save();
          $this->getConfig()->set("sign-z", $event->getBlock()->getZ());
          $this->getConfig()->save();
          $this->getConfig()->set("sign-world", $event->getPlayer()->getLevel()->getName());
          $this->getConfig()->save();
          $this->getConfig()->set("sign-mode", true);
          $this->getConfig()->save;
          $event->setLine(0, "§l[§6L§eB§cW§f]");
          $event->setLine(1, "§aJoin");
       }else{
          $event->setLine(0, "No");
          $event->setLine(1, "Permission");
       }
    }
 }
 
 public function onDeath(PlayerDeathEvent $event){
    if($this->running == true){
       if(in_array($event->getEntity()->getName(), $this->players)){
          unset($this->players{array_search($event->getEntity()->getName(), $this->players)});
          $event->setDeathMessage($this->cfg["death-message"]);
          $event->getEntity()->teleport($this->getServer()->getLevelByName($this->cfg["respawn-level"])->getSafeSpawn());
       }
       if(count($this->players == 1)){
          $this->getServer()->getPlayer($this->players)->teleport($this->getServer()->getLevelByName($this->cfg["respawn-level"])->getSafeSpawn());
          $this->getServer()->broadcastMessage(str_replace(["{name}", "health"], [$this->players, $this->getServer()->getPlayer($this->players)->getHealth()], $this->cfg["won-broadcast"]));
          $this->getServer()->getPlayer(this->players)->setHealth(20);
          unset($this->players{array_search($this->players, $this->players)});
          $this->running = false;
       }
    }
 }
 
 public function onInteract(PlayerInteractEvent $event){
    if($event->getBlock()->getX() === $this->cfg["sign-x"] and $event->getBlock()->getY() === $this->cfg["sign-y"] and $event->getBlock()->getZ() === $this->cfg["sign-z"]){
       if($this->running == false){
          $this->addToGame($event->getPlayer()->getName());
       }else{
          $event->getPlayer()->sendMessage($this->cfg["game-is-running"]);
       }
    }
 }
  
}
