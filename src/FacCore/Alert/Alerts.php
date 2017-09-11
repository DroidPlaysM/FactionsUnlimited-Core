<?php
namespace FacCore\Alert;

use pocketmine\Server;
use pocketmine\scheduler\PluginTask;
use pocketmine\utils\TextFormat;

class Alerts extends PluginTask {
	public function onRun(int $currentTick) {
		$input = [
			"• Tip » Vote at ______ to get crate keys and coins.",
			"• Tip » Do ".TextFormat::WHITE."/rules".TextFormat::GRAY." to get a list of our Server Rules!",
			"• Tip » Staff abusing? DM us on twitter @RealFactionsMC with proof and We'll take action for you.",
			"• Tip » Donations makes the server stay Alive and get better Builds and plugins. Buy ranks at ___________.",
			"• NOTICE » We are still in BETA. Please report any bugs on Twitter.",
			"• Tip » Follow us on Twitter @RealFactionsMC to get the Latest Server Updates and events that goes on.",
			"• Factions » We hope you're Enjoying your GamePlay! Send some FeedBack by DMing us on Twitter",
			"• Tip » Do ".TextFormat::WHITE."/f help".TextFormat::GRAY." to see all Faction commands.",
			"• Tip » Do ".TextFormat::WHITE."/f create".TextFormat::GRAY." to make a Factions.",
			"• Need Help? Try typing ".TextFormat::WHITE."/help",
			"• Thanks for playing on Factions Unlimited!",
			"• Hacking is NOT allowed on Factions Unlimited, Disable client mods before playing",
			"• We know are server is not perfect but we will always try to improve it."
		];
		$messages = array_rand($input);
		Server::getInstance()->broadcastMessage(TextFormat::GRAY . $input[$messages]);
	}
}