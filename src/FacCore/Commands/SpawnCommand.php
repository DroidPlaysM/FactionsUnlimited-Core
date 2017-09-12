<?php
namespace FacCore\Commands;

use FacCore\Main;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\plugin\Plugin;

class SpawnCommand extends PluginCommand {
	public function __construct(Main $owner) {
		parent::__construct($owner->getLanguage()->get("spawn.name"), $owner);
		$this->setUsage($owner->getLanguage()->get("spawn.usage"));
		$this->setPermission("core.command.spawn");
		$this->setDescription($owner->getLanguage()->get("spawn.desc"));
	}
	public function execute(CommandSender $sender, string $commandLabel, array $args) {
		if(!$this->testPermission($sender) or !$sender instanceof Player) {
			return true;
		}
		if(!$sender->teleport(
			new Position(
				$this->getPlugin()->getConfig()->getNested("spawn.x", 0),
				$this->getPlugin()->getConfig()->getNested("spawn.y", 64),
				$this->getPlugin()->getConfig()->getNested("spawn.z", 0),
				$this->getPlugin()->getServer()->getLevelByName(
					$this->getPlugin()->getConfig()->getNested("spawn.world", "world")
				)
			)
		)) {
			$sender->sendMessage($this->getPlugin()->getLanguage()->get("error"));
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
		$arr["overloads"]["default"]["input"]["parameters"] = [];
		return $arr;
	}
}