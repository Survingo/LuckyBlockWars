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
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\Listener;
use pocketmine\math\Vector3;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use Survingo\LuckyBlockWars\tasks\WaitPopupTask;
use Survingo\LuckyBlockWars\tasks\StartGameTask;

class LuckyBlockWars extends PluginBase implements Listener{
   
  public $running = false;
  
  public $prefix = ("[§6Lucky §eBlock §cWars§f] ");
  
  public $players = array();
   
  public function onEnable(){
     $this->getServer()->getLogger()->info($this->prefix . "Enabling " . $this->getDescription()->getFullName() . " by Survingo...");
     @mkdir($this->getDataFolder());
     $this->saveResource("config.yml");//$this->saveDefaultConfig();
     $cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
     $this->cfg = $cfg->getAll();
  }
  
  public function onDisable(){
     $this->getServer()->getLogger()->info($this->prefix . "Disabling plugin...");
     $this->
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
           $event->getPlayer()->sendMessage($this->cfg["not-allowed-to-use-luckyblock"]);
        }
     }
  }
 
 public function getRandom(array $things){
    if(is_array($things)) return $things[array_rand($things, 1)];
 }
 
 public function unluckyBlockStuff($block){
    return array(
       $boom = new \pocketmine\level\Explosion($block, mt_rand($this->cfg["min-explosion"], $this->cfg["max-explosion"]));
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
 
 public function onSignChange(SignChangeEvent $event){
    //add to config
 }
 
 public function onInteract(PlayerInteractEvent $event){
    if($event->getBlock()->getX() === $this->cfg["sign-x"] and $event->getBlock()->getY() === $this->cfg["sign-y"] and $event->getBlock()->getZ() === $this->cfg["sign-z"]){
       //join
    }
 }
 
 public function getPlayersInGame(){
    return $this->players;
 }
 
 public function startGame(){
    if(count($this->players == $this->cfg["needed-players"])){
       $this->running = true;
       foreach($players as $player){
          $player->sendMessage("[LuckyBlockWars] Starting game...");
          $this->getServer()->getScheduler()->scheduleRepeatingTask(new StartGameTask($plugin), 20)->getTaskId();
          $this->getServer()->getScheduler()->cancelTask($this->waitPopup);
       }
    }else{
      $this->waitPopup = $this->getServer()->getScheduler()->scheduleRepeatingTask(new WaitPopupTask($plugin), 20)->getTaskId();
    }
  }
  
 public function onCommand(CommandSender $sender, Command $command, $label, array $args){
    switch(strtolower($command->getName())){
       case "lbw":
          if($sender instanceof Player){
             if(!(isset($args[0]))){
                if($sender->hasPermission("lucky-block-wars.command")){
                   $this->getServer()->dispatchCommand($sender, "lbw help");
                }
             }
          }
          $arg = array_shift($args);
          switch($args){
             case "help":
                if($sender->hasPermission("lucky-block-wars.command.help")){
                   $sender->sendMessage("----------");
                   $sender->sendMessage($this->prefix . "Help");
                   $sender->sendMessage("----------");
                   return true;
                }else{
                   $sender->sendMessage("§cYou don't have the permission to run the help!");
                   return true;
                }
                break;
             default:
                $sender->sendMessage($this->prefix . "Unknown command. Type §7/lbw §fto get a list of commands.");
          }
    }
 }
 
}
