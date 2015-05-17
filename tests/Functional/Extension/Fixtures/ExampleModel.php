<?php

namespace Tests\Bleicker\Persistence\Functional\Extension\Fixtures;

use DateTime;

/**
 * Class ExampleModel
 *
 * @package Tests\Bleicker\Persistence\Functional\Extension\Fixtures
 */
class ExampleModel {

	/**
	 * @var integer
	 */
	protected $id;

	/**
	 * @var DateTime
	 */
	protected $dateTime;

	/**
	 * @param DateTime $dateTime
	 * @return $this
	 */
	public function setDateTime(DateTime $dateTime = NULL) {
		$this->dateTime = $dateTime;
		return $this;
	}

	/**
	 * @return DateTime
	 */
	public function getDateTime() {
		return $this->dateTime;
	}
}
