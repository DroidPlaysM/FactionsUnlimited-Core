<?php

namespace FacCore;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as TF;
use pocketmine\scheduler\PluginTask;
use pocketmine\utils\Config;
use pocketmine\event\Listener;

use FacCore\Events\RestartEvent;
use FacCore\Alert\AlertTask;
