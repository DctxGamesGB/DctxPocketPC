<?php

declare(strict_types=1);

namespace pocketmine\chest\type;

/**
 * An InvMenuType with a fixed inventory size.
 */
interface FixedInvMenuType extends InvMenuType{

	/**
	 * Returns size (number of slots) of the inventory.
	 *
	 * @return int
	 */
	public function getSize() : int;
}