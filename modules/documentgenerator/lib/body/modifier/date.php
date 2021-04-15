<?php

namespace Bitrix\DocumentGenerator\Body\Modifier;

use Bitrix\DocumentGenerator\Body\Modifier;

class Date extends Modifier
{
	/**
	 * Date constructor.
	 * @param \Bitrix\Main\Type\Date $date
	 */
	public function __construct(\Bitrix\Main\Type\Date $date)
	{
		parent::__construct($date);
	}

	/**
	 * @param string $format - Date format in bitrix culture style 'DD.MM.YYYY'
	 * @return string
	 */
	public function process($format)
	{
		return $this->value->format(\Bitrix\Main\Type\Date::convertFormatToPhp($format));
	}
}