<?php

namespace Survingo\LuckyBlocks\game;

use pocketmine\Player;
use pocketmine\item\Item;

use Survingo\LuckyBlockWars\LuckyBlockWars;

class LuckyBlocks{
  
  private $plugin;
  
  private $block;
  
  private $player;
  
  public function __construct(LuckyBlockWars $plugin, $block, Player $player){
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
