<?php

declare(strict_types=1);

namespace pocketmine\chest\session\network\handler;

use Closure;
use pocketmine\chest\session\network\NetworkStackLatencyEntry;

interface PlayerNetworkHandler{

	public function createNetworkStackLatencyEntry(Closure $then) : NetworkStackLatencyEntry;
}