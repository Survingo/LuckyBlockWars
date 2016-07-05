<?php

namespace Survingo\LuckyBlocks\LuckyBlock;

use Survingo\LuckyBlockWars\LuckyBlockWars;

class LuckyBlocks{
  
  private $block;
  
  public function __construct(LuckyBlockWars $plugin, $block){
    $this->block = $block;
  }
  
  public function doLuckyStuff(){
    //
  }
  
}
