<?php

namespace Survingo\LuckyBlocks\LuckyBlock;

use pocketmine\Player;

use Survingo\LuckyBlockWars\LuckyBlockWars;

class LuckyBlocks{
  
  private $plugin;
  
  private $block;
  
  public function __construct(LuckyBlockWars $plugin, $block, Player $player){
    $this->block = $block;
    $this->plugin = $plugin;
    $this->block = $block;
  }
  
  public function run(){
    switch(mt_rand(1,2)){
      case 1: $player->getLevel()->dropItem($this->block, Item::get(Item::DIAMOND,0,1,"{display:{Name:"§b§lLucky Diamond"}}"));
      break;
      case 2:
      break;
    }
  }
  
}
