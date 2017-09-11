<?php
namespace FacCore;

use FacCore\Events\EventListener;
use FacCore\Tasks\AutoRestartTask;
use pocketmine\event\Listener;
use pocketmine\lang\BaseLang;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

class Main extends PluginBase implements Listener {

	/** @var BaseLang $baseLang */
	private $baseLang = null;

	public function onLoad() {
		$this->getLogger()->notice(TextFormat::GREEN . "Starting Factions Core");
		$this->saveDefaultConfig();
	}

	public function onEnable() {
		$this->getLogger()->notice(base64_decode("ICBfX19fX18gICAgICAgICAgICAgICAgICBfICAgICBfICAgICAgICAgICAgICAgICAgICAgICAgIF8gICAgXyAgICAgICAgICAgXyAgIF8gICAgICAgICAgICAgICBfICAgXyAgICAgICAgICAgICAgICBfICAgIF9fX19fICAgICAgICAgICAgICAgICAgICAgICANCiB8ICBfX19ffCAgICAgICAgICAgICAgICB8IHwgICAoXykgICAgICAgICAgICAgICAgICAgICAgIHwgfCAgfCB8ICAgICAgICAgfCB8IChfKSAgICAgICAgICAgICAoXykgfCB8ICAgICAgICAgICAgICB8IHwgIC8gX19fX3wgICAgICAgICAgICAgICAgICAgICAgDQogfCB8X18gICAgICBfXyBfICAgIF9fXyAgfCB8XyAgIF8gICAgX19fICAgIF8gX18gICAgX19fICB8IHwgIHwgfCAgXyBfXyAgIHwgfCAgXyAgIF8gX18gX19fICAgIF8gIHwgfF8gICAgX19fICAgIF9ffCB8IHwgfCAgICAgICAgX19fICAgIF8gX18gICAgX19fIA0KIHwgIF9ffCAgICAvIF9gIHwgIC8gX198IHwgX198IHwgfCAgLyBfIFwgIHwgJ18gXCAgLyBfX3wgfCB8ICB8IHwgfCAnXyBcICB8IHwgfCB8IHwgJ18gYCBfIFwgIHwgfCB8IF9ffCAgLyBfIFwgIC8gX2AgfCB8IHwgICAgICAgLyBfIFwgIHwgJ19ffCAgLyBfIFwNCiB8IHwgICAgICB8IChffCB8IHwgKF9fICB8IHxfICB8IHwgfCAoXykgfCB8IHwgfCB8IFxfXyBcIHwgfF9ffCB8IHwgfCB8IHwgfCB8IHwgfCB8IHwgfCB8IHwgfCB8IHwgfCB8XyAgfCAgX18vIHwgKF98IHwgfCB8X19fXyAgfCAoXykgfCB8IHwgICAgfCAgX18vDQogfF98ICAgICAgIFxfXyxffCAgXF9fX3wgIFxfX3wgfF98ICBcX19fLyAgfF98IHxffCB8X19fLyAgXF9fX18vICB8X3wgfF98IHxffCB8X3wgfF98IHxffCB8X3wgfF98ICBcX198ICBcX19ffCAgXF9fLF98ICBcX19fX198ICBcX19fLyAgfF98ICAgICBcX19ffA0KICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICANCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAg"));
		// Events
		new EventListener($this);
		//Messages
		$lang = $this->getConfig()->get("language", BaseLang::FALLBACK_LANGUAGE);
		$this->baseLang = new BaseLang($lang, $this->getFile() . "resources/");
		//TODO: Alerts system
		//Tasks
		$this->getServer()->getScheduler()->scheduleDelayedTask(new AutoRestartTask($this), 20 * 60 * 60 * 12); // Delay: 12 Hours
		$this->getServer()->getScheduler()->scheduleRepeatingTask(new Alerts($this), 2000);
		//TODO: other tasks
		//Commands

		$this->getLogger()->info(TextFormat::GREEN . "Everything Running fine i think :P");
		$this->registerCommands();
	}
	public function registerCommands(){
		$this->getServer()->getCommandMap()->register("fly", new FlyCommand($this));
	}
			
	public function getLanguage() : BaseLang {
		return $this->baseLang;
	}
	public function onDisable() {
		$this->getLogger()->info(TextFormat::RED ."Shutting down Factions Core");
	}
	public function getWarpsConfig() : Config {
		return new Config($this->getDataFolder()."warps.yml", Config::YAML);
	}
}
