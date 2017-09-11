<?php
namespace FacCore\Events;

use FacCore\Main;
use pocketmine\command\Command;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\event\server\ServerCommandEvent;

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

	/**
	 * @priority HIGHEST
	 * @ignoreCancelled true
	 *
	 * @param ServerCommandEvent $ev
	 */
	public function onServerCommand(ServerCommandEvent $ev) {
		if($ev->isCancelled())
			return;
		$text = $ev->getCommand();
		$arr = explode(" ", $text);
		$cmd = $arr[0];
		array_shift($arr);
		/** @var Command $command */
		foreach($this->plugin->getServer()->getCommandMap()->getCommands() as $command) {
			if(strtolower($command->getName()) === strtolower($cmd))
				return;
			foreach($command->getAliases() as $alias) {
				if(strtolower($alias) === strtolower($cmd))
					return;
			}
		}
		$ev->setCancelled();
		$this->plugin->getServer()->getPluginManager()->callEvent($event = new ServerChatEvent($this->plugin, $text));
		if(!$event->isCancelled()) {
			$this->plugin->getServer()->broadcastMessage($this->plugin->getServer()->getLanguage()->translateString("chat.type.text", [$event->getTitle(), $event->getMessage()]));
		}
	}
}