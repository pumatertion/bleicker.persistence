<?php
namespace Bleicker\Persistence;

use Bleicker\Persistence\Extensions\UtcDateTime;
use Doctrine\Common\EventManager;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager as EntityManagerOrigin;

/**
 * Class EntityManager
 */
class EntityManager extends EntityManagerOrigin implements EntityManagerInterface {

	/**
	 * {@inheritdoc}
	 */
	public static function create($conn, Configuration $config, EventManager $eventManager = NULL) {
		$entityManager = EntityManagerOrigin::create($conn, $config, $eventManager);
		static::registerDoctrineTypes($entityManager->getConnection()->getDatabasePlatform());
		return $entityManager;
	}

	/**
	 * @param AbstractPlatform $platform
	 * @return void
	 */
	protected static function registerDoctrineTypes(AbstractPlatform $platform) {
		if (Type::hasType('datetime')) {
			Type::overrideType('datetime', UtcDateTime::class);
		} else {
			Type::addType('datetime', UtcDateTime::class);
			$platform->registerDoctrineTypeMapping('datetime', 'datetime');
		}
	}
}
