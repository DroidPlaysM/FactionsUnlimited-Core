<?php
namespace FacCore\Events;

use FacCore\Main;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerPreLoginEvent;

class EventListener implements Listener {
	private $plugin;
	public function __construct(Main $plugin) {
		$this->plugin = $plugin;
		$plugin->getServer()->getPluginManager()->registerEvents($this, $plugin);
	}

	/**
	 * @priority HIGHEST
	 * @ignoreCancelled true
	 *
	 * @param PlayerPreLoginEvent $ev
	 */
	public function onPreLogin(PlayerPreLoginEvent $ev) {
		if($ev->isCancelled())
			return;
		$player = $ev->getPlayer();
		if($this->plugin->getIPLocks()->exists($player->getName())) {
			if(empty($this->plugin->getIPLocks()->get($player->getName(), []))) {
				$this->plugin->getIPLocks()->set($player->getName(), [$player->getAddress()]);
			}else{
				if(!in_array($player->getAddress(), $this->plugin->getIPLocks()->get($player->getName()))) {
					$ev->setCancelled();
					$ev->setKickMessage("This username can only join from a few set IP addresses.\nNo hacking accounts here :P"); //TODO move message to multi-lang
				}
			}
		}
	}
}