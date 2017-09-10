<?php
namespace FacCore\Tasks;

use pocketmine\scheduler\PluginTask;

class AutoRestartTask extends PluginTask {
	public function onRun(int $currentTick){
		$this->getOwner()->getServer()->shutdown();
	}
}