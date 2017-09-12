<?php
namespace FacCore\Commands;

use FacCore\Main;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\plugin\Plugin;

class TPACommand extends PluginCommand {
	public function __construct(Main $owner) {
		parent::__construct($owner->getLanguage()->get("tpa.name"), $owner);
		$this->setUsage($owner->getLanguage()->get("tpa.usage"));
		$this->setPermission("core.command.tpa");
		$this->setDescription($owner->getLanguage()->get("tpa.desc"));
	}
	public function execute(CommandSender $sender, string $commandLabel, array $args) {
		if(!$this->testPermission($sender) or !$sender instanceof Player) {
			return true;
		}
		//TODO
		return true;
	}
	/**
	 * @return Main
	 */
	public function getPlugin() : Plugin {
		return parent::getPlugin();
	}
	public function generateCustomCommandData(Player $player) : array {
		$players = [$player->getName()];
		foreach($this->getPlugin()->getServer()->getOnlinePlayers() as $onlinePlayer) {
			$players[] = $onlinePlayer->getName();
		}
		sort($players, SORT_FLAG_CASE);
		$arr = parent::generateCustomCommandData($player);
		$arr["overloads"]["default"]["input"]["parameters"] = [
			[
				"name" => "player",
				"type" => "stringenum",
				"optional" => false,
				"enum_values" => $players
			]
		];
		return $arr;
	}
}