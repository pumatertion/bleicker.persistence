<?php

namespace Bleicker\Persistence\Extensions;

use DateTime;
use DateTimeZone;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\DateTimeType;
use Exception;

/**
 * Class UtcDateTime
 *
 * @package Bleicker\Persistence\Extensions
 */
class UtcDateTime extends DateTimeType {

	/**
	 * @param DateTime $value
	 * @param AbstractPlatform $platform
	 * @return string
	 */
	public function convertToDatabaseValue($value, AbstractPlatform $platform) {
		if ($value === NULL) {
			return NULL;
		}
		$utcDateTimeString = $value->setTimezone(new DateTimeZone('UTC'))->format($platform->getDateTimeFormatString());
		return $utcDateTimeString;
	}

	/**
	 * @param string $value
	 * @param AbstractPlatform $platform
	 * @return DateTime
	 * @throws ConversionException
	 */
	public function convertToPHPValue($value, AbstractPlatform $platform) {
		if ($value === NULL) {
			return NULL;
		}
		try {
			return DateTime::createFromFormat($platform->getDateTimeFormatString(), $value, new DateTimeZone('UTC'));
		} catch (Exception $exception) {
			throw ConversionException::conversionFailed($value, $this->getName(), $exception);
		}
	}
}
