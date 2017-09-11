<?php

namespace FacCore\Alert;

use pocketmine\Server;
use pocketmine\scheduler\PluginTask;
use pocketmine\utils\TextFormat as C;
use FacCore\Main;

class Alerts extends PluginTask {

    public function __construct(Main $plugin){
        parent::__construct($plugin);
        $this->plugin = $plugin;
    }

    public function onRun($currentTick){
    	$this->plugin = $this->getOwner();
        $input = array(
        "§7• Tip » Vote at ______ to get crate keys and coins.",
        "§7• Tip » Do /rules to get a list of our Server Rules!",
        "§7• Tip » Staff abusing? DM us on twitter @RealFactionsMC with proof and We'll take action for you.",
        "§7• Tip » Donations makes the server stay Alive and get better Builds and plugins. Buy ranks at ___________.",
        "§7• NOTICE » We are still in BETA. Please report any bugs on Twitter.",
        "§7• Tip » Follow us on Twitter @RealFactionsMC to get the Latest Server Updates and events that goes on.",
        "§7• Factions » We hope you're Enjoying your GamePlay! Send some FeedBack by DMing us on Twitter",
        "§7• Tip » Do /f help to see all Faction commands.",
        "§7• Tip » Do /f create to make a Factions.",
        "§7• Need Help? Try typing §f/help",
        "§7• Thanks for playing on Factions Unlimited!",
        "§7• Hacking is NOT allowed on Factions Unlimited, Disable client mods before playing",
        "§7• We know are server is not perfect but we will always try to improve it."
        ); 
        $messages = array_rand($input);
    	Server::getInstance()->broadcastMessage(C::GRAY . $input[$messages]);
    	}
}
?>
