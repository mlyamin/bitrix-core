<?php

namespace Bitrix\Location\Source\Google;

use Bitrix\Location\Common\Pool;
use Bitrix\Location\Entity\Source;
use Bitrix\Location\Repository\Location\IRepository;
use Bitrix\Location\Common\CachedPool;
use Bitrix\Main\Data\Cache;
use Bitrix\Main\EventManager;
use Bitrix\Main\Web\HttpClient;

/**
 * Class GoogleSource
 * @package Bitrix\Location\Source\Google
 * @internal
 */
class GoogleSource extends Source
{
	/**
	 * @inheritDoc
	 */
	public function makeRepository(): IRepository
	{
		static $result = null;

		if (!is_null($result))
		{
			return $result;
		}

		$httpClient = new HttpClient(
			[
				'version' => '1.1',
				'socketTimeout' => 30,
				'streamTimeout' => 30,
				'redirect' => true,
				'redirectMax' => 5,
			]
		);

		if (defined('LOCATION_GOOGLE_PROXY_HOST'))
		{
			$proxyHost = LOCATION_GOOGLE_PROXY_HOST;
			$proxyPort = null;

			if(defined('LOCATION_GOOGLE_PROXY_PORT'))
			{
				$proxyPort = LOCATION_GOOGLE_PROXY_PORT;
			}

			$httpClient->setProxy($proxyHost, $proxyPort);
		}

		$cacheTTL = 2592000; //month
		$poolSize = 100;
		$pool = new Pool($poolSize);

		$cachePool = new CachedPool(
			$pool,
			$cacheTTL,
			'locationSourceGoogleRequester',
			Cache::createInstance(),
			EventManager::getInstance()
		);

		$result = new Repository(
			$this->config->getValue('API_KEY_BACKEND'),
			$httpClient,
			$this,
			$cachePool
		);

		return $result;
	}

	/**
	 * @inheritDoc
	 */
	public function getJSParams(): array
	{
		return [
			'apiKey' => $this->config->getValue('API_KEY_FRONTEND'),
			'showPhotos' => $this->config->getValue('SHOW_PHOTOS_ON_MAP'),
			'useGeocodingService' => $this->config->getValue('USE_GEOCODING_SERVICE'),
		];
	}

	/**
	 * @inheritDoc
	 *
	 * @see https://developers.google.com/maps/faq#languagesupport
	 */
	public function convertLang(string $bitrixLang): string
	{
		$langMap = [
			'br' => 'pt-BR',	// Portuguese (Brazil)
			'la' => 'es', 		// Spanish
			'sc' => 'zh-CN', 	// Chinese (Simplified)
			'tc' => 'zh-TW', 	// Chinese (Traditional)
			'vn' => 'vi' 		// Vietnamese
		];

		return $langMap[$bitrixLang] ?? $bitrixLang;
	}
}
