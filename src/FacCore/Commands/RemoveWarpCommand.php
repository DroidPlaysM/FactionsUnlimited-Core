<?php
namespace FacCore\Commands;

use FacCore\Main;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\plugin\Plugin;

class RemoveWarpCommand extends PluginCommand {
	public function __construct(Main $owner) {
		parent::__construct($owner->getLanguage()->get("removewarp.name"), $owner);
		$this->setUsage($owner->getLanguage()->get("removewarp.usage"));
		$this->setPermission("core.command.warp.remove");
		$this->setDescription($owner->getLanguage()->get("removewarp.desc"));
		$this->setAliases([$owner->getLanguage()->get("removewarp.alias")]);
	}
	public function execute(CommandSender $sender, string $commandLabel, array $args) {
		if(!$this->testPermission($sender)) {
			return true;
		}
		if(empty($args)) {
			return false;
		}
		$this->getPlugin()->getWarpsConfig()->remove($args[0]);
		$sender->sendMessage($this->getPlugin()->getLanguage()->translateString("removewarp.success"));
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
		$warps = $this->getPlugin()->getWarpsConfig()->getAll(true);
		$arr["overloads"]["default"]["input"]["parameters"] = [
			[
				"name" => "warp",
				"type" => "stringenum",
				"optional" => false,
				"enum_values" => $warps
			]
		];
		return $arr;
	}
}