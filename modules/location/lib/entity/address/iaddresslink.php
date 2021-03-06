<?php
namespace Bitrix\Location\Entity\Address;

/**
 * Interface IAddressLink
 * @package Bitrix\Location\Entity\Address
 * This interface could be used for entities witch has link with addresses
 */
interface IAddressLink
{
	/**
	 * Returns linked entity identifier
	 * @return string
	 */
	public function getAddressLinkEntityId(): string;

	/**
	 * Returns linked entity type
	 * @return string
	 */
	public function getAddressLinkEntityType(): string;
}