<?php

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
