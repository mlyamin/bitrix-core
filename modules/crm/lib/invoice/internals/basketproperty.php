<?php
namespace Bitrix\Crm\Invoice\Internals;

use Bitrix\Main;
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

class BasketPropertyTable extends Main\Entity\DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'b_crm_invoice_basket_props';
	}

	/**
	 * Returns entity map definition.
	 *
	 * @return array
	 */
	public static function getMap()
	{
		return array(
			new Main\Entity\IntegerField(
				'ID',
				 array(
					 'autocomplete' => true,
					 'primary' => true,
				 )
			),
			new Main\Entity\IntegerField(
				'BASKET_ID',
				 array(
					 'required' => true,
				 )
			),
			new Main\Entity\StringField(
				'NAME',
				array(
					'size' => 255,
					'validation' => array(__CLASS__, 'validateName'),
				)
			),
			new Main\Entity\StringField(
				'VALUE',
				array(
					'size' => 255,
					'validation' => array(__CLASS__, 'validateValue'),
				)
			),
			new Main\Entity\StringField(
				'CODE',
				array(
					'size' => 255,
					'validation' => array(__CLASS__, 'validateCode'),
				)
			),
			new Main\Entity\StringField('XML_ID'),

			new Main\Entity\IntegerField(
				'SORT'
			),
			new Main\Entity\ReferenceField(
				'BASKET',
				'Bitrix\Sale\Internals\Basket',
				array(
					'=this.BASKET_ID' => 'ref.ID'
				)
			),
		);
	}
	/**
	 * Returns validators for NAME field.
	 *
	 * @return array
	 */
	public static function validateName()
	{
		return array(
			new Main\Entity\Validator\Length(null, 255),
		);
	}
	/**
	 * Returns validators for VALUE field.
	 *
	 * @return array
	 */
	public static function validateValue()
	{
		return array(
			new Main\Entity\Validator\Length(null, 255),
		);
	}
	/**
	 * Returns validators for CODE field.
	 *
	 * @return array
	 */
	public static function validateCode()
	{
		return array(
			new Main\Entity\Validator\Length(null, 255),
		);
	}
}