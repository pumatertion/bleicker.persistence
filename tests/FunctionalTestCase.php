<?php
namespace Tests\Bleicker\Persistence;

use Bleicker\Persistence\EntityManager;
use Bleicker\Persistence\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\Setup;

/**
 * Class FunctionalTestCase
 *
 * @package Tests\Bleicker\Persistence
 */
abstract class FunctionalTestCase extends BaseTestCase {

	/**
	 * @var EntityManagerInterface
	 */
	protected $entityManager;

	protected function setUp() {
		parent::setUp();
		$this->entityManager = EntityManager::create(
			['driver'=>'pdo_sqlite', 'path' => __DIR__ .'/testing.sqlite', 'dbname' => 'testing.sqlite'],
			Setup::createYAMLMetadataConfiguration($this->getSchemaPaths(), TRUE)
		);
		$this->initDB();
	}

	protected function tearDown() {
		parent::tearDown();
		$this->destroyDB();
	}

	protected function destroyDB() {
		$tool = new SchemaTool($this->entityManager);
		$tool->dropSchema($this->entityManager->getMetadataFactory()->getAllMetadata());
	}

	protected function initDB() {
		$tool = new SchemaTool($this->entityManager);
		$tool->dropSchema($this->entityManager->getMetadataFactory()->getAllMetadata());
		$tool->createSchema($this->entityManager->getMetadataFactory()->getAllMetadata());
	}

	/**
	 * @return array
	 */
	abstract protected function getSchemaPaths();
}
