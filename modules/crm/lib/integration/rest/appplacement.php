<?php
namespace Bitrix\Crm\Integration\Rest;
class AppPlacement
{
	const LEAD_LIST_MENU = 'CRM_LEAD_LIST_MENU';
	const DEAL_LIST_MENU = 'CRM_DEAL_LIST_MENU';
	const INVOICE_LIST_MENU = 'CRM_INVOICE_LIST_MENU';
	const QUOTE_LIST_MENU = 'CRM_QUOTE_LIST_MENU';
	const CONTACT_LIST_MENU = 'CRM_CONTACT_LIST_MENU';
	const COMPANY_LIST_MENU = 'CRM_COMPANY_LIST_MENU';
	const ACTIVITY_LIST_MENU = 'CRM_ACTIVITY_LIST_MENU';
	const ANALYTICS_MENU = 'CRM_ANALYTICS_MENU';
	const LEAD_DETAIL_TAB = 'CRM_LEAD_DETAIL_TAB';
	const DEAL_DETAIL_TAB = 'CRM_DEAL_DETAIL_TAB';
	const CONTACT_DETAIL_TAB = 'CRM_CONTACT_DETAIL_TAB';
	const COMPANY_DETAIL_TAB = 'CRM_COMPANY_DETAIL_TAB';
	const ORDER_DETAIL_TAB = 'CRM_ORDER_DETAIL_TAB';
	const LEAD_DETAIL_ACTIVITY = 'CRM_LEAD_DETAIL_ACTIVITY';
	const DEAL_DETAIL_ACTIVITY = 'CRM_DEAL_DETAIL_ACTIVITY';
	const CONTACT_DETAIL_ACTIVITY = 'CRM_CONTACT_DETAIL_ACTIVITY';
	const COMPANY_DETAIL_ACTIVITY = 'CRM_COMPANY_DETAIL_ACTIVITY';
	const ORDER_DETAIL_ACTIVITY = 'CRM_ORDER_DETAIL_ACTIVITY';
	const LEAD_DETAIL_TOOLBAR = 'CRM_LEAD_DETAIL_TOOLBAR';
	const DEAL_DETAIL_TOOLBAR = 'CRM_DEAL_DETAIL_TOOLBAR';
	const CONTACT_DETAIL_TOOLBAR = 'CRM_CONTACT_DETAIL_TOOLBAR';
	const COMPANY_DETAIL_TOOLBAR = 'CRM_COMPANY_DETAIL_TOOLBAR';
	const REQUISITE_EDIT_FORM = 'CRM_REQUISITE_EDIT_FORM';
	const ONEC_PAGE = '1C_PAGE';

	public static function getAll()
	{
		return [
			self::LEAD_LIST_MENU,
			self::DEAL_LIST_MENU,
			self::INVOICE_LIST_MENU,
			self::QUOTE_LIST_MENU,
			self::CONTACT_LIST_MENU,
			self::COMPANY_LIST_MENU,
			self::ACTIVITY_LIST_MENU,
			self::ANALYTICS_MENU,
			self::LEAD_DETAIL_TAB,
			self::DEAL_DETAIL_TAB,
			self::CONTACT_DETAIL_TAB,
			self::COMPANY_DETAIL_TAB,
			self::ORDER_DETAIL_TAB,
			self::LEAD_DETAIL_ACTIVITY,
			self::DEAL_DETAIL_ACTIVITY,
			self::CONTACT_DETAIL_ACTIVITY,
			self::COMPANY_DETAIL_ACTIVITY,
			self::ORDER_DETAIL_ACTIVITY,
			self::LEAD_DETAIL_TOOLBAR ,
			self::DEAL_DETAIL_TOOLBAR,
			self::CONTACT_DETAIL_TOOLBAR,
			self::COMPANY_DETAIL_TOOLBAR,
			self::REQUISITE_EDIT_FORM,
			self::ONEC_PAGE
		];
	}
}