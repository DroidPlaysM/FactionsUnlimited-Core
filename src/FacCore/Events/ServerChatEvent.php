<?php
namespace FacCore\Events;

use pocketmine\event\Cancellable;
use pocketmine\event\plugin\PluginEvent;
use pocketmine\plugin\Plugin;

class ServerChatEvent extends PluginEvent implements Cancellable {
	/** @var string $message */
	private $message;
	/** @var string $title */
	private $title;
	/**
	 * ServerChatEvent constructor.
	 *
	 * @param Plugin $plugin
	 * @param string $message
	 */
	public function __construct(Plugin $plugin, string $message) {
		parent::__construct($plugin);
		$this->message = $message;
		$this->title = "CONSOLE";
	}
	/**
	 * @return string
	 */
	public function getMessage() : string {
		return $this->message;
	}
	/**
	 * @param string $message
	 */
	public function setMessage(string $message) {
		$this->message = $message;
	}
	/**
	 * @return string
	 */
	public function getTitle() : string {
		return $this->title;
	}
	/**
	 * @param string $title
	 */
	public function setTitle(string $title) {
		$this->title = $title;
	}
}