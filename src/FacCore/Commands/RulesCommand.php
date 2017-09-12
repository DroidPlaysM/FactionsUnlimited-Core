<?php
namespace FacCore\Commands;

use FacCore\Main;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\utils\TextFormat;

class RulesCommand extends PluginCommand {
	public function __construct(Main $owner) {
		parent::__construct($owner->getLanguage()->get("rules.name"), $owner);
		$this->setUsage($owner->getLanguage()->get("rules.usage"));
		$this->setPermission("core.command.rules");
		$this->setDescription($owner->getLanguage()->get("rules.desc"));
	}
	public function execute(CommandSender $sender, string $commandLabel, array $args) {
		if(!$this->testPermission($sender) or !$sender instanceof Player) {
			return true;
		}
		$sender->sendMessage(TextFormat::YELLOW.$this->getPlugin()->getLanguage()->translateString("rules.list"));
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