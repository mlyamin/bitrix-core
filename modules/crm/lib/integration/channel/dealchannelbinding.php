<?php
namespace Bitrix\Crm\Integration\Channel;

use Bitrix\Main;
use Bitrix\Crm\Statistics\DealChannelStatisticEntry;

/**
 * Class DealChannelBinding
 * Managing of Deal bindings to external channels.
 * @package Bitrix\Crm\Integration\Channel
 */
class DealChannelBinding
{
	/**
	 * Get all bindings to channels for specified Deal.
	 * @param int $ID Deal ID.
	 * @return array
	 * @throws Main\ArgumentException
	 */
	public static function getAll($ID)
	{
		return EntityChannelBinding::getAll(\CCrmOwnerType::Deal, $ID);
	}
	/**
	 * Check if specified Deal has bindings to channel.
	 * @param int $ID Deal ID.
	 * @return bool
	 * @throws Main\ArgumentException
	 */
	public static function exists($ID)
	{
		return EntityChannelBinding::exists(\CCrmOwnerType::Deal, $ID);
	}
	/**
	 * Register binding to the channel for specified Deal.
	 * @param int $ID Deal ID.
	 * @param ChannelType $typeID Channel Type ID.
	 * @param array $params Array of binding parameters. For example ORIGIN_ID and COMPONENT_ID.
	 * @return void
	 * @throws Main\ArgumentException
	 */
	public static function register($ID, $typeID, array $params = null)
	{
		EntityChannelBinding::register(\CCrmOwnerType::Deal, $ID, $typeID, $params);
		DealChannelStatisticEntry::register($ID, $typeID, $params);
	}
	public static function attach($srcEntityTypeID, $srcEntityID, $dstEntityID)
	{
		$bindings = EntityChannelBinding::getAll($srcEntityTypeID, $srcEntityID);
		foreach($bindings as $binding)
		{
			$typeID = isset($binding['TYPE_ID']) ? (int)$binding['TYPE_ID'] : ChannelType::UNDEFINED;
			if(ChannelType::isDefined($typeID))
			{
				self::register($dstEntityID, $typeID, $binding);
			}
		}
	}
	public static function detach($srcEntityTypeID, $srcEntityID, $dstEntityID)
	{
		$bindings = EntityChannelBinding::getAll($srcEntityTypeID, $srcEntityID);
		foreach($bindings as $binding)
		{
			$typeID = isset($binding['TYPE_ID']) ? (int)$binding['TYPE_ID'] : ChannelType::UNDEFINED;
			if(ChannelType::isDefined($typeID))
			{
				self::unregister($dstEntityID, $typeID);
			}
		}
	}
	/**
	 * Synchronize Deal statistics.
	 * @param int $ID Deal ID
	 * @param array $fields Deal Fields
	 * @throws Main\ArgumentException
	 */
	public static function synchronize($ID, array $fields)
	{
		foreach(self::getAll($ID) as $binding)
		{
			$typeID = isset($binding['TYPE_ID']) ? (int)$binding['TYPE_ID'] : ChannelType::UNDEFINED;
			if(ChannelType::isDefined($typeID))
			{
				DealChannelStatisticEntry::register($ID, $typeID, $binding, $fields);
			}
		}
	}
	/**
	 * Unregister binding to the channel for specified Deal.
	 * @param int $ID Deal ID.
	 * @param ChannelType $typeID Channel Type ID.
	 * @return void
	 * @throws Main\ArgumentException
	 */
	public static function unregister($ID, $typeID)
	{
		EntityChannelBinding::unregister(\CCrmOwnerType::Deal, $ID, array(array('TYPE_ID' => $typeID)));
		DealChannelStatisticEntry::unregister($ID, $typeID);
	}
	/**
	 * Unregister bindings to all channels for specified Deal.
	 * @param int $ID Deal ID.
	 * @return void
	 * @throws Main\ArgumentException
	 */
	public static function unregisterAll($ID)
	{
		EntityChannelBinding::unregisterAll(\CCrmOwnerType::Deal, $ID);
		DealChannelStatisticEntry::unregister($ID);
	}
}