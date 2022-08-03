<?php

namespace pocketmine\entity;

use pocketmine\world\World;
use pocketmine\nbt\tag\{CompoundTag, ListTag, DoubleTag, FloatTag};
use pocketmine\math\Vector3;

class LegacyEntity {

    	/**
	 * Creates an entity with the specified type, level and NBT, with optional additional arguments to pass to the
	 * LegacyEntity's constructor
	 *
	 * @param int|string  $type
	 * @param mixed       ...$args
	 */
	public static function createEntity($type, World $world, CompoundTag $nbt, ...$args) : ?LegacyEntity{
		if(isset(self::$knownEntities[$type])){
			$class = self::$knownEntities[$type];
			/** @see LegacyEntity::__construct() */
			return new $class($world, $nbt, ...$args);
		}

		return null;
	}

	/**
	 * Registers an entity type into the index.
	 *
	 * @param string   $className Class that extends LegacyEntity
	 * @param bool     $force Force registration even if the entity does not have a valid network ID
	 * @param string[] $saveNames An array of save names which this entity might be saved under. Defaults to the short name of the class itself if empty.
	 * @phpstan-param class-string<LegacyEntity> $className
	 *
	 * NOTE: The first save name in the $saveNames array will be used when saving the entity to disk. The reflection
	 * name of the class will be appended to the end and only used if no other save names are specified.
	 */
	public static function registerEntity(string $className, bool $force = false, array $saveNames = []) : bool{
		$class = new \ReflectionClass($className);
		if(is_a($className, LegacyEntity::class, true) and !$class->isAbstract()){
			if($className::NETWORK_ID !== -1){
				self::$knownEntities[$className::NETWORK_ID] = $className;
			}elseif(!$force){
				return false;
			}

			$shortName = $class->getShortName();
			if(!in_array($shortName, $saveNames, true)){
				$saveNames[] = $shortName;
			}

			foreach($saveNames as $name){
				self::$knownEntities[$name] = $className;
			}

			self::$saveNames[$className] = reset($saveNames);

			return true;
		}

		return false;
	}

	/**
	 * Helper function which creates minimal NBT needed to spawn an LegacyEntity.
	 */
	public static function createBaseNBT(Vector3 $pos, ?Vector3 $motion = null, float $yaw = 0.0, float $pitch = 0.0) : CompoundTag{
		return new CompoundTag("", [
			new ListTag("Pos", [
				new DoubleTag("", $pos->x),
				new DoubleTag("", $pos->y),
				new DoubleTag("", $pos->z)
			]),
			new ListTag("Motion", [
				new DoubleTag("", $motion !== null ? $motion->x : 0.0),
				new DoubleTag("", $motion !== null ? $motion->y : 0.0),
				new DoubleTag("", $motion !== null ? $motion->z : 0.0)
			]),
			new ListTag("Rotation", [
				new FloatTag("", $yaw),
				new FloatTag("", $pitch)
			])
		]);
	}
}