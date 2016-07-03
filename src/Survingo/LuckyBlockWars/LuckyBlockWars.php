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

use pocketmine\Player;
use pocketmine\math\Vector3;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use Survingo\LuckyBlockWars\tasks\WaitPopupTask;
use Survingo\LuckyBlockWars\tasks\StartGameTask;
use Survingo\LuckyBlockWars\tasks\StatusSignTask;

class LuckyBlockWars extends PluginBase{
   
  public $running = false;
  
  public $prefix = ("[§6Lucky §eBlock §cWars§f] ");
  
  public $players = array();
  
  public $msg;
   
  public function onEnable(){
     $this->getServer()->getLogger()->info($this->prefix . "Enabling " . $this->getDescription()->getFullName() . " by Survingo...");
     @mkdir($this->getDataFolder());
     $this->saveDefaultConfig();
     $this->saveResource("messages.yml");
     $messages = new Config($this->getDataFolder() . "messages.yml", Config::YAML);
     $this->msg = $messages->getAll();
     $this->getServer()->getPluginManager()->registerEvents(new EventManager($this), $this);
     $this->getServer()->getScheduler()->scheduleRepeatingTask(new StatusSignTask($this), 20 * 3);
  }
  
  public function onDisable(){
     $this->getServer()->getLogger()->info($this->prefix . "Disabling plugin...");
  }
 
 public function getRandom(array $things){
    if(is_array($things)) return $things[array_rand($things, 1)];
 }

 public function addToGame($name){
    if(count($this->players !== $this->getConfig()->get("needed-players"))){
       if(!in_array($name, $this->players)){
          array_push($this->players, $name);
          $this->getServer()->getPlayer($name)->teleport(new Position($this->getConfig()->get("lobby-x"), $this->getConfig()->get("lobby-y"), $this->getConfig()->get("lobby-z"), $this->getConfig()->get("lobby-world")));
          return true;
       }
    }
 }
 
 public function startGame(){
    if(count($this->players == $this->getConfig()->get("needed-players"))){
       foreach($this->getServer()->getPlayer($this->players) as $player){
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
                if($sender->hasPermission("lbw.command")){
                   $this->getServer()->dispatchCommand($sender, "lbw help");
                }
             }
          }
          $arg = array_shift($args);
          switch($args){
             case "help":
             case "list-commands":
             case "list-cmds":
             case "list":
             case "?":
                if($sender->hasPermission("lbw.command.help")){
                   $sender->sendMessage("----------");
                   $sender->sendMessage($this->prefix . "List of sub-commands");
                   $sender->sendMessage("----------");
                   $sender->sendMessage("§2version: §fShows information about this plugin");
                   return true;
                }else{
                   $sender->sendMessage("§cYou don't have the permission to run the help!");
                   return true;
                }
                break;
             case "version":
             case "info":
             case "information":
                if($sender->hasPermission("lbw.command.version")){
                   $sender->sendMessage($this->prefix . "Developed by §lSurvingo§r.\nCurrent version installed: §7" . $this->getDescription()->getVersion());
                   return true;
                }
                break;
             case "join":
             case "enter":
             case "play":
                if($sender instanceof Player){
                   if($sender->hasPermission("lbw.command.join")){
                      $this->addToGame($sender);
                   }else{
                      $sender->sendMessage("§cYou do not have the permission to do that!");
                   }
                }else{
                   $sender->sendMessage("§cYou can not run that command via the console!");
                }
             default:
                $sender->sendMessage($this->prefix . "Unknown command. Type §7/lbw §fto get a list of commands.");
                return true;
                break;
          }
    }
 }
 
}
