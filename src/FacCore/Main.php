<?php
namespace FacCore;

use FacCore\Commands\RemoveWarpCommand;
use FacCore\Commands\RulesCommand;
use FacCore\Commands\SetWarpCommand;
use FacCore\Commands\SpawnCommand;
use FacCore\Commands\TPACommand;
use FacCore\Commands\WarpCommand;
use FacCore\Events\EventListener;
use FacCore\Tasks\AutoRestartTask;
use FacCore\Commands\FlyCommand;
use FacCore\Alert\Alerts;

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
		//Messages
		$lang = $this->getConfig()->get("language", BaseLang::FALLBACK_LANGUAGE);
		$this->baseLang = new BaseLang($lang, $this->getFile() . "resources/");
		//Commands
		$this->getServer()->getCommandMap()->registerAll($this->getDescription()->getName(), [
			new FlyCommand($this),
			new RemoveWarpCommand($this),
			new RulesCommand($this),
			new SetWarpCommand($this),
			new SpawnCommand($this),
			//new TPACommand($this), //TODO
			new WarpCommand($this)
		]);
	}
	public function onEnable() {
		$this->getLogger()->notice(base64_decode("IF9fXyAgICAgICAgICAgICAgICAgIF8gICAgICAgICAgICAgICAgICAgICAgICAgICBfICAgXyAgICAgICAgIF8gICAgICAgICAgICAgICAgICAgICBfICAgICAgICAgICAgICAgXyAgX19fICAgICAgICAgICAgICAgICAgICAgICANCiggIF9gXCAgICAgICAgICAgICAgICggKV8gIF8gICAgICAgICAgICAgICAgICAgICAoICkgKCApICAgICAgIChfICkgIF8gICAgICAgICAgICAgXyAoIClfICAgICAgICAgICAgKCApKCAgX2BcICAgICAgICAgICAgICAgICAgICAgDQp8IChfKF8pICAgXyBfICAgIF9fXyB8ICxfKShfKSAgIF8gICAgIF9fXyAgICBfX18gfCB8IHwgfCAgX19fICAgfCB8IChfKSAgX19fIF9fXyAgKF8pfCAsXykgICBfXyAgICAgX3wgfHwgKCAoXykgICBfICAgIF8gX18gICAgX18gIA0KfCAgXykgICAvJ19gICkgLydfX18pfCB8ICB8IHwgLydfYFwgLycgXyBgXC8nLF9fKXwgfCB8IHwvJyBfIGBcIHwgfCB8IHwvJyBfIGAgXyBgXHwgfHwgfCAgIC8nX19gXCAvJ19gIHx8IHwgIF8gIC8nX2BcICggJ19fKSAvJ19fYFwNCnwgfCAgICAoIChffCB8KCAoX19fIHwgfF8gfCB8KCAoXykgKXwgKCApIHxcX18sIFx8IChfKSB8fCAoICkgfCB8IHwgfCB8fCAoICkgKCApIHx8IHx8IHxfICggIF9fXy8oIChffCB8fCAoXyggKSggKF8pICl8IHwgICAoICBfX18vDQooXykgICAgYFxfXyxfKWBcX19fXylgXF9fKShfKWBcX19fLycoXykgKF8pKF9fX18vKF9fX19fKShfKSAoXykoX19fKShfKShfKSAoXykgKF8pKF8pYFxfXylgXF9fX18pYFxfXyxfKShfX19fLydgXF9fXy8nKF8pICAgYFxfX19fKQ0KICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICANCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAg"));
		// Events
		new EventListener($this);
		//Tasks
		$this->getServer()->getScheduler()->scheduleDelayedTask(new AutoRestartTask($this), 20 * 60 * 60 * 12); // Delay: 12 Hours
		$this->getServer()->getScheduler()->scheduleRepeatingTask(new Alerts($this), 2000); // Repeats every 100 seconds
		//TODO: other tasks
	}
	public function getLanguage() : BaseLang {
		return $this->baseLang;
	}
	public function onDisable() {
		$this->getLogger()->notice(TextFormat::RED ."Shutting down Factions Core");
	}
	public function getWarpsConfig() : Config {
		return new Config($this->getDataFolder()."warps.yml", Config::YAML);
	}
}