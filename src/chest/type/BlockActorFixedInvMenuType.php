<?php

declare(strict_types=1);

namespace pocketmine\chest\type;

use pocketmine\chest\inventory\InvMenuInventory;
use pocketmine\chest\InvMenu;
use pocketmine\chest\type\graphic\BlockActorInvMenuGraphic;
use pocketmine\chest\type\graphic\InvMenuGraphic;
use pocketmine\chest\type\graphic\network\InvMenuGraphicNetworkTranslator;
use pocketmine\chest\type\util\InvMenuTypeHelper;
use pocketmine\block\Block;
use pocketmine\inventory\Inventory;
use pocketmine\player\Player;

final class BlockActorFixedInvMenuType implements FixedInvMenuType{

	public function __construct(
		private Block $block,
		private int $size,
		private string $tile_id,
		private ?InvMenuGraphicNetworkTranslator $network_translator = null,
		private int $animation_duration = 0
	){}

	public function getSize() : int{
		return $this->size;
	}

	public function createGraphic(InvMenu $menu, Player $player) : ?InvMenuGraphic{
		$origin = $player->getPosition()->addVector(InvMenuTypeHelper::getBehindPositionOffset($player))->floor();
		if(!InvMenuTypeHelper::isValidYCoordinate($origin->y)){
			return null;
		}

		return new BlockActorInvMenuGraphic($this->block, $origin, BlockActorInvMenuGraphic::createTile($this->tile_id, $menu->getName()), $this->network_translator, $this->animation_duration);
	}

	public function createInventory() : Inventory{
		return new InvMenuInventory($this->size);
	}
}