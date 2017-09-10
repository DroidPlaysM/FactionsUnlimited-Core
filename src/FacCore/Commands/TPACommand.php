<?php
namespace FacCore\Commands;

use FacCore\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\plugin\Plugin;

class TPACommand extends PluginCommand {
	public function __construct(Main $owner) {
		parent::__construct($this->getPlugin()->getLanguage()->get("tpa.name"), $owner);
		$this->setUsage($this->getPlugin()->getLanguage()->get("tpa.usage"));
		$this->setPermission("core.command.tpa");
		$this->setDescription($this->getPlugin()->getLanguage()->get("tpa.desc"));
	}
	public function execute(CommandSender $sender, string $commandLabel, array $args) {
		if(!$this->testPermission($sender)) {
			return true;
		}
		//TODO
	}
	/**
	 * @return Main
	 */
	public function getPlugin() : Plugin {
		return parent::getPlugin();
	}
	public function getDefaultCommandData() : array {
		$arr = parent::getDefaultCommandData();
		$arr["overloads"]["default"]["input"]["parameters"] = [];
		return $arr;
	}
}