<?php
namespace FacCore\Events;

use FacCore\Main;
use pocketmine\event\Listener;

class EventListener implements Listener {
	private $plugin;
	public function __construct(Main $plugin) {
		$this->plugin = $plugin;
		$plugin->getServer()->getPluginManager()->registerEvents($this, $plugin);
	}
	//TODO
}