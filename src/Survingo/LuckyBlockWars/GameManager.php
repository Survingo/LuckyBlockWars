<?php

namespace Survingo\LuckyBlockWars;

class GameManager{
  
  public $running = false;
  
  public $players = array();
  
  public function __construct(LuckyBlockWars $plugin){
    $this->plugin = $plugin;
    $this->running = false;
  }
  
  public function startGame(array $players){
    $this->running = true;
    $this->players = $players;
    $player1 = $players[1];
    $player2 = $players[2];
    $player3 = $players[3];
    $player4 = $players[4];
    foreach($players as $player){
      $player->sendMessage("[LuckyBlockWars] Starting game...");
      $player->setHealth(20);
    }
  }
  
}
