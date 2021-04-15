<?php

namespace Bitrix\DocumentGenerator\Body;

abstract class Modifier
{
	protected $value;

	/**
	 * Modifier constructor.
	 * @param mixed $value
	 */
	public function __construct($value)
	{
		$this->value = $value;
	}

	/**
	 * @param string
	 * @return string
	 */
	abstract public function process($param);
}