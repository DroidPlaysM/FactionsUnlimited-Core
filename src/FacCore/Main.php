<?php

namespace FacCore;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as TF;
use pocketmine\scheduler\PluginTask;
use pocketmine\utils\Config;
use pocketmine\event\Listener;

use FacCore\Events\RestartEvent;
use FacCore\Alert\Alerts;

class Main extends PluginBase implements Listener {
  
  public function onEnable(){
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    $this->config = (new Config($this->getDataFolder()."config.yml", Config::YAML));
    $this->saveResource("config.yml");
    $this->saveDefaultConfig();
    $this->getLogger()->info(C::GREEN ."Starting Factions Core ");
    //Alerts
    $this->getServer()->getScheduler()->scheduleRepeatingTask(new Alerts($this), 2000);
    //RestartEvent
    $this->getServer()->getScheduler()->scheduleRepeatingTask(new RestartEvent($this), 20);
        
      $this->registerCommands();
  }
  
  	public function registerCommands(){
