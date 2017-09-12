<?php
namespace FacCore\Commands;

use FacCore\Main;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\plugin\Plugin;

class SetWarpCommand extends PluginCommand {
	public function __construct(Main $owner) {
		parent::__construct($this->getPlugin()->getLanguage()->get("setwarp.name"), $owner);
		$this->setUsage($this->getPlugin()->getLanguage()->get("setwarp.usage"));
		$this->setPermission("core.command.warp.add");
		$this->setDescription($this->getPlugin()->getLanguage()->get("setwarp.desc"));
	}
	public function execute(CommandSender $sender, string $commandLabel, array $args) {
		if(!$this->testPermission($sender) or !$sender instanceof Player) {
			return true;
		}
		if(empty($args)) {
			return false;
		}
		$this->getPlugin()->getWarpsConfig()->set($args[0], [
			"x" => $sender->getFloorX(),
			"y" => $sender->getFloorY(),
			"z" => $sender->getFloorZ(),
			"world" => $sender->getLevel()->getFolderName()
		]);
		if($this->getPlugin()->getWarpsConfig()->save(true)){
			$sender->sendMessage($this->getPlugin()->getLanguage()->get("error"));
		}else{
			$sender->sendMessage($this->getPlugin()->getLanguage()->translateString("setwarp.success", $args[0]));
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
				"name" => "name",
				"type" => "rawtext",
				"optional" => false
			]
		];
		return $arr;
	}
}