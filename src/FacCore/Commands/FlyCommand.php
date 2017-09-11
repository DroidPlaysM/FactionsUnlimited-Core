<?php
namespace FacCore\Commands;

use FacCore\Main;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\utils\TextFormat;

class FlyCommand extends PluginCommand {
	public function __construct(Main $owner) {
		parent::__construct($this->getPlugin()->getLanguage()->get("fly.name"), $owner);
		$this->setUsage($this->getPlugin()->getLanguage()->get("fly.usage"));
		$this->setPermission("core.command.fly");
		$this->setDescription($this->getPlugin()->getLanguage()->get("fly.desc"));
	}
	public function execute(CommandSender $sender, string $commandLabel, array $args) {
		if(!$this->testPermission($sender) or !$sender instanceof Player) {
			return true;
		}
		var_dump($args); //TODO remove after testing
		if($sender->hasPermission("core.command.fly")) {
			if (isset($args[0])) {
				switch ($args[0]) {
					case "on":
						$sender->sendMessage(TextFormat::YELLOW.$this->getPlugin()->getLanguage()->translateString("fly.enabled"));
						$sender->setAllowFlight(true);
					break;
					case "off":
						$sender->sendMessage(TextFormat::YELLOW.$this->getPlugin()->getLanguage()->translateString("fly.disabled"));
						$sender->setAllowFlight(false);
					break;
					default:
						$sender->setAllowFlight(!$sender->getAllowFlight()); // toggle by default
				}
			}else{
				$sender->setAllowFlight(!$sender->getAllowFlight()); // toggle by default
			}
		}
		return true;
	}
	/**
	 * @return Main
	 */
	public function getPlugin() : Plugin {
		return parent::getPlugin();
	}
	public function generateCustomCommandData(Player $player) : array {
		$arr = parent::generateCustomCommandData($player);
		$arr["overloads"]["default"]["input"]["parameters"] = [
			[
				"name" => "value",
				"type" => "bool",
				"optional" => true
			]
		];
		return $arr;
	}
}