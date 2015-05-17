<?php

namespace Tests\Bleicker\Persistence\Functional\Extension;

use DateTime;
use Tests\Bleicker\Persistence\Functional\Extension\Fixtures\ExampleModel;
use Tests\Bleicker\Persistence\FunctionalTestCase;

/**
 * Class UtcDateTimeTest
 *
 * @package Tests\Bleicker\Persistence\Functional\Extension
 */
class UtcDateTimeTest extends FunctionalTestCase {

	/**
	 * @test
	 */
	public function isStoredAsDateTimeTest() {
		$entity = new ExampleModel();
		$entity->setDateTime(new DateTime());
		$this->entityManager->persist($entity);
		$this->entityManager->flush();
		$this->entityManager->clear($entity);
		/** @var ExampleModel $storedEntity */
		$storedEntity = $this->entityManager->getRepository(ExampleModel::class)->find(1);
		$this->assertInstanceOf(DateTime::class, $storedEntity->getDateTime());
	}

	/**
	 * @test
	 */
	public function isStoredAsDateTimeInUtcTest() {
		$entity = new ExampleModel();
		$dateTime = new DateTime('17.05.2015 12:00:00', new \DateTimeZone('Australia/Tasmania'));
		$entity->setDateTime($dateTime);
		$this->entityManager->persist($entity);
		$this->entityManager->flush();
		$this->entityManager->clear();
		/** @var ExampleModel $storedEntity */
		$storedEntity = $this->entityManager->getRepository(ExampleModel::class)->find(1);
		$this->assertEquals('2015-05-17 02:00:00', $storedEntity->getDateTime()->format('Y-m-d H:i:s'));
	}

	/**
	 * @return array
	 */
	protected function getSchemaPaths() {
		return [__DIR__ . '/Schemas/UtcDateTimeTest'];
	}
}
