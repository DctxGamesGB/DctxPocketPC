<?php

declare(strict_types=1);

namespace pocketmine\chest\type\util\builder;

use pocketmine\chest\type\InvMenuType;

interface InvMenuTypeBuilder{

	public function build() : InvMenuType;
}