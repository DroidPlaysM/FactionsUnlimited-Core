<?php

namespace FacCore\Commands;

use FacCore\Main;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat as TF;

class FlyCommand extends PluginCommand {
  
  public function __construct(Main $plugin) {
    $this->plugin = $plugin;
    parent::__construct($plugin, "fly", "", "/fly [on|off]", []);
  }
  
  public function execute(CommandSender $sender, string $commandLabel, array $args) {
  	if(!$sender instanceof Player) {
  		$sender->sendMessage(TF::RED . "You must run this command in-game.");
  		return false;
  		
  	}
  	
  	if (count($args) < 1) {
      $sender->sendMessage(TF::RED . $this->usageMessage);
      return true;
    }
    
  	if($sender->hasPermission("fac.command.fly")) {
  		if (isset($args[0])) {
  			switch ($args[0]) {
  				case "on":
  					$sender->sendMessage("You have enabled fly");
  					$sender->setAllowFlight(true);
  			}
  		}
  		
  		if (isset($args[0])) {
  			switch ($args[0]) {
  				case "off":
  					$sender->sendMessage("You have disabled fly");
  					$sender->setAllowFlight(false);
  			}
  		}
  	}
  }
}
