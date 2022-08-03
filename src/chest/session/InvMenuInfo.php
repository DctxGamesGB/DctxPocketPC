<?php

declare(strict_types=1);

namespace pocketmine\chest\session;

use pocketmine\chest\InvMenu;
use pocketmine\chest\type\graphic\InvMenuGraphic;

final class InvMenuInfo{

	public function __construct(
		public InvMenu $menu,
		public InvMenuGraphic $graphic,
		public ?string $graphic_name
	){}
}