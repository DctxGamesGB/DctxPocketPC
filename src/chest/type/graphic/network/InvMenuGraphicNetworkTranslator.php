<?php

declare(strict_types=1);

namespace pocketmine\chest\type\graphic\network;

use pocketmine\chest\session\InvMenuInfo;
use pocketmine\chest\session\PlayerSession;
use pocketmine\network\mcpe\protocol\ContainerOpenPacket;

interface InvMenuGraphicNetworkTranslator{

	public function translate(PlayerSession $session, InvMenuInfo $current, ContainerOpenPacket $packet) : void;
}