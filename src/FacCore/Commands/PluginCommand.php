<?php

namespace FacCore\Commands;

use FacCore\Main;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\plugin\Plugin;

class PluginCommand extends Command implements PluginIdentifiableCommand{
	/** @var Plugin */
	private $plugin;
	/** @var CommandExecutor */
	private $executor;
	/**
	 * @param string $name
	 * @param Plugin $owner
	 */

	public function __construct(Main $plugin, $name, $description, $usageMessage, $aliases){
        parent::__construct($name, $description, $usageMessage, $aliases);
		$this->plugin = $plugin;
	}
	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(!$this->Plugin->isEnabled()){
			return false;
		}
		if(!$this->testPermission($sender)){
			return false;
		}
		$success = $this->executor->onCommand($sender, $this, $commandLabel, $args);
		if(!$success and $this->usageMessage !== ""){
			throw new InvalidCommandSyntaxException();
		}
		return $success;
	}
	public function getExecutor() : CommandExecutor{
		return $this->executor;
	}
	/**
	 * @param CommandExecutor $executor
	 */
	public function setExecutor(CommandExecutor $executor){
		$this->executor = $executor;
	}
	/**
	 * @return Plugin
	 */
	public function getPlugin() : Plugin{
		return $this->owningPlugin;
	}
}
