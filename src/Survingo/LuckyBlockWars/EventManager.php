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
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerQuitEvent;

class EventManager implements Listener{
  /** @var LuckyBlockWars */
  private $plugin;
  
  public function __construct(LuckyBlockWars $plugin){
    $this->plugin = $plugin;
  }
  
  public function onBlockBreak(BlockBreakEvent $event){
     if($event->getBlock()->getId() == $this->plugin->getConfig("luckyblock-id")){
        if($this->plugin->running === true){
           if($event->getPlayer()->hasPermission("lbw.game.use")){
              switch(mt_rand(1,3)){
                 case 1: $this->getRandom($this->unluckyBlockStuff($event->getBlock()));
                 break;
                 case 2: $this->getRandom($this->normalBlockStuff($event->getBlock()));
                 break;
                 case 3: $this->getRandom($this->luckyBlockStuff($event->getBlock()));
                 break;
              }
           }else{
              $event->setCancelled(true);
              $event->getPlayer()->sendMessage($this->plugin->msg["not-allowed-to-use-luckyblock"]);
           }
        }else{
           $event->getPlayer()->sendMessage($this->plugin->msg["game-is-not-running"]);
        }
     }
  }
  
  public function onSignChange(SignChangeEvent $event){
    if($event->getLine(0) == "[LBW]" or $event->getLine(0) == "[LuckyBlock]" or $event->getLine(0) == "/lbw join"){
       if($event->getPlayer()->hasPermission("lbw.game.create-signs")){
          $this->plugin->getConfig()->set("sign-x", $event->getBlock()->getX());
          $this->plugin->getConfig()->save();
          $this->plugin->getConfig()->set("sign-y", $event->getBlock()->getY());
          $this->plugin->getConfig()->save();
          $this->plugin->getConfig()->set("sign-z", $event->getBlock()->getZ());
          $this->plugin->getConfig()->save();
          $this->plugin->getConfig()->set("sign-world", $event->getPlayer()->getLevel()->getName());
          $this->plugin->getConfig()->save();
          $this->plugin->getConfig()->set("sign-mode", true);
          $this->plugin->getConfig()->save;
          $event->setLine(0, "§l[§6L§eB§cW§f]");
          $event->setLine(1, "§aJoin");
       }else{
          $event->setLine(0, "No");
          $event->setLine(1, "Permission");
       }
    }
 }
 
 public function onDeath(PlayerDeathEvent $event){
    if($this->plugin->running == true){
       if(in_array($event->getEntity()->getName(), $this->plugin->players)){
          unset($this->plugin->players{array_search($event->getEntity()->getName(), $this->plugin->players)});
          $event->setDeathMessage($this->plugin->prefix . str_replace("{name}", $event->getEntity()->getName(), $this->plugin->msg["death-message"]));
          $event->getEntity()->teleport($this->plugin->getServer()->getLevelByName($this->plugin->getConfig()->get("respawn-level"))->getSafeSpawn());
       }
       if(count($this->plugin->players == 1)){
          $this->plugin->getServer()->getPlayer($this->plugin->players)->teleport($this->->plugin->getServer()->getLevelByName($this->plugin->cfg["respawn-level"])->getSafeSpawn());
          $this->plugin->getServer()->broadcastMessage($this->plugin->prefix . str_replace(["{name}", "{health}"], [$this->plugin->players, $this->plugin->getServer()->getPlayer($this->plugin->players)->getHealth()], $this->plugin->getConfig()->get("won-broadcast")));
          $this->plugin->getServer()->getPlayer($this->plugin->players)->setHealth(20);
          $this->plugin->players = array();
          $this->plugin->running = false;
       }
    }
 }
 
 public function onInteract(PlayerInteractEvent $event){
    if($event->getBlock()->getX() === $this->plugin->cfg["sign-x"] and $event->getBlock()->getY() === $this->plugin->cfg["sign-y"] and $event->getBlock()->getZ() === $this->plugin->cfg["sign-z"]){
       if($this->plugin->running == false){
          $this->addToGame($event->getPlayer()->getName());
       }else{
          $event->getPlayer()->sendMessage($this->plugin->cfg["game-is-running"]);
       }
    }
 }
 
 public function onQuit(PlayerQuitEvent $event){
    if($this->plugin->running == true){
       if(in_array($event->getPlayer()->getName(), $this->plugin->players)){
          unset($this->plugin->players{array_search($event->getPlayer()->getName(), $this->plugin->players)});
          $event->setQuitMessage($this->plugin->cfg["quit-message"]);
          $event->getPlayer()->teleport($this->plugin->getServer()->getLevelByName($this->plugin->cfg["respawn-level"])->getSafeSpawn());
       }
       if(count($this->plugin->players) == 1){
          $this->plugin->getServer()->getPlayer($this->plugin->players)->teleport($this->->plugin->getServer()->getLevelByName($this->plugin->cfg["respawn-level"])->getSafeSpawn());
          $this->plugin->getServer()->broadcastMessage(str_replace(["{name}", "{health}"], [$this->plugin->players, $this->plugin->getServer()->getPlayer($this->plugin->players)->getHealth()], $this->plugin->cfg["won-broadcast"]));
          $this->plugin->getServer()->getPlayer($this->plugin->players)->setHealth(20);
          $this->plugin->players = array();
          $this->plugin->running = false;
       }
    }
 }
  
}
