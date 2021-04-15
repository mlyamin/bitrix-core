<?php

namespace Bitrix\Main\Engine\Response;

use Bitrix\Main;
use Bitrix\Main\Context;
use Bitrix\Main\Text\Encoding;

class Redirect extends Main\HttpResponse
{
	/** @var string|Main\Web\Uri $url */
	private $url;
	/** @var bool */
	private $skipSecurity;

	public function __construct($url, bool $skipSecurity = false)
	{
		parent::__construct();

		$this
			->setStatus('302 Found')
			->setSkipSecurity($skipSecurity)
			->setUrl($url)
		;
	}

	/**
	 * @return Main\Web\Uri|string
	 */
	public function getUrl()
	{
		return $this->url;
	}

	/**
	 * @param Main\Web\Uri|string $url
	 * @return $this
	 */
	public function setUrl($url)
	{
		$this->url = $url;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function isSkippedSecurity(): bool
	{
		return $this->skipSecurity;
	}

	/**
	 * @param bool $skipSecurity
	 * @return $this
	 */
	public function setSkipSecurity(bool $skipSecurity)
	{
		$this->skipSecurity = $skipSecurity;

		return $this;
	}

	private function checkTrial(): bool
	{
		$isTrial =
			defined("DEMO") && DEMO === "Y" &&
			(
				!defined("SITEEXPIREDATE") ||
				!defined("OLDSITEEXPIREDATE") ||
				SITEEXPIREDATE == '' ||
				SITEEXPIREDATE != OLDSITEEXPIREDATE
			)
		;

		return $isTrial;
	}

	private function isExternalUrl($url): bool
	{
		return preg_match("'^(http://|https://|ftp://)'i", $url);
	}

	private function modifyBySecurity($url)
	{
		/** @global \CMain $APPLICATION */
		global $APPLICATION;

		$isExternal = $this->isExternalUrl($url);
		if(!$isExternal && strpos($url, "/") !== 0)
		{
			$url = $APPLICATION->GetCurDir() . $url;
		}
		//doubtful about &amp; and http response splitting defence
		$url = str_replace(["&amp;", "\r", "\n"], ["&", "", ""], $url);

		if (!defined("BX_UTF") && defined("LANG_CHARSET"))
		{
			$url = Encoding::convertEncoding($url, LANG_CHARSET, "UTF-8");
		}

		return $url;
	}

	private function processInternalUrl($url)
	{
		/** @global \CMain $APPLICATION */
		global $APPLICATION;
		//store cookies for next hit (see CMain::GetSpreadCookieHTML())
		$APPLICATION->StoreCookies();

		$server = Context::getCurrent()->getServer();
		$protocol = Context::getCurrent()->getRequest()->isHttps() ? "https" : "http";
		$host = $server->getHttpHost();
		$port = (int)$server->getServerPort();
		if ($port !== 80 && $port !== 443 && $port > 0 && strpos($host, ":") === false)
		{
			$host .= ":" . $port;
		}

		return "{$protocol}://{$host}{$url}";
	}

	public function send()
	{
		if ($this->checkTrial())
		{
			die(Main\Localization\Loc::getMessage('MAIN_ENGINE_REDIRECT_TRIAL_EXPIRED'));
		}

		$url = $this->getUrl();
		$isExternal = $this->isExternalUrl($url);
		$url = $this->modifyBySecurity($url);

		/*ZDUyZmZYWRkYjU0NzRhODhhMTQ4OGM1YmU5MjM1OTYxOTMzZWE=*/$GLOBALS['____700095446']= array(base64_decode('bX'.'Rf'.'cm'.'F'.'uZA=='),base64_decode(''.'aXNfb2J'.'qZWN0'),base64_decode('Y2FsbF91c2'.'Vy'.'X2Z'.'1'.'b'.'m'.'M='),base64_decode('Y'.'2F'.'sbF91c2'.'VyX2Z1bmM='),base64_decode('Z'.'XhwbG'.'9kZQ=='),base64_decode('cGFja'.'w'.'='.'='),base64_decode('bWQ1'),base64_decode(''.'Y29u'.'c3'.'Rh'.'bnQ='),base64_decode('aGFza'.'F9obWFj'),base64_decode('c3RyY21'.'w'),base64_decode(''.'aW'.'50'.'dm'.'Fs'),base64_decode('Y2FsbF91c2Vy'.'X2Z1bmM'.'='));if(!function_exists(__NAMESPACE__.'\\___1030476461')){function ___1030476461($_871440062){static $_1338479880= false; if($_1338479880 == false) $_1338479880=array(''.'VVNF'.'Ug==','VV'.'N'.'FUg==','VVNF'.'Ug='.'=','SXNB'.'dXRob3JpemVk','VVNF'.'U'.'g'.'==',''.'SX'.'NBZ'.'G1pb'.'g'.'==','R'.'E'.'I=','U0VMRU'.'NUIFZBTFVFIE'.'ZST0'.'0gYl9'.'vcHRpb'.'2'.'4gV0'.'hFU'.'kUg'.'T'.'kFNRT0'.'nflB'.'BUkFN'.'X01BWF9VU0VSUycgQ'.'U5EIE1PRFV'.'M'.'RV'.'9JRD0nbWFp'.'bicg'.'Q'.'U5E'.'IFNJVEV'.'fSUQgSVMgTlV'.'MTA'.'==','VkFMVU'.'U=','Lg==','SCo'.'=',''.'Yml0cml4','TElDRU'.'5TR'.'V9LRVk=','c2hhMj'.'U2','R'.'EI=','U0VMRUNUI'.'ENPVU5UKF'.'UuSUQp'.'IG'.'Fz'.'IEMgRl'.'JPTSBi'.'X3VzZX'.'IgV'.'SBXSEVSRSB'.'VLkFDVEl'.'WRS'.'A9ICd'.'Z'.'JyBBTkQ'.'gVS5MQVNUX0'.'xP'.'R0lOIElT'.'I'.'E5PVCBOVUxMIEFORCBFW'.'ElTVFMoU0'.'V'.'M'.'RUNU'.'IC'.'d4JyBGUk9NIGJfd'.'XRtX3VzZ'.'XI'.'gVUYsIGJf'.'dXNlcl9'.'maWVsZC'.'B'.'GIFdIR'.'VJ'.'FI'.'EYuRU'.'5'.'US'.'VRZ'.'X0lEID0'.'gJ1VTRVI'.'nIEFO'.'RCBGLkZJR'.'UxEX0'.'5B'.'TUUgPSAnVUZfREVQQVJUT'.'UVOVCcgQU'.'5EIFV'.'G'.'L'.'kZ'.'JRUx'.'EX0lE'.'ID0g'.'Ri5JRCBBTk'.'Q'.'gV'.'UYuVk'.'F'.'MV'.'UVfSU'.'QgPSBVLklEIEF'.'ORCB'.'V'.'Ri'.'5WQUx'.'V'.'RV9JTlQgS'.'V'.'MgTk9UIE5VTE'.'wg'.'QU'.'5'.'EIFV'.'GLlZBT'.'FVFX0lOVC'.'A'.'8PiAwK'.'Q='.'=','Qw==','VV'.'N'.'FUg==','T'.'G9n'.'b3V0');return base64_decode($_1338479880[$_871440062]);}};if($GLOBALS['____700095446'][0](round(0+1), round(0+10+10)) == round(0+1.4+1.4+1.4+1.4+1.4)){ if(isset($GLOBALS[___1030476461(0)]) && $GLOBALS['____700095446'][1]($GLOBALS[___1030476461(1)]) && $GLOBALS['____700095446'][2](array($GLOBALS[___1030476461(2)], ___1030476461(3))) &&!$GLOBALS['____700095446'][3](array($GLOBALS[___1030476461(4)], ___1030476461(5)))){ $_70991144= $GLOBALS[___1030476461(6)]->Query(___1030476461(7), true); if(!($_1727003830= $_70991144->Fetch())) $_55725607= round(0+3+3+3+3); $_1599095325= $_1727003830[___1030476461(8)]; list($_1991699070, $_55725607)= $GLOBALS['____700095446'][4](___1030476461(9), $_1599095325); $_367815790= $GLOBALS['____700095446'][5](___1030476461(10), $_1991699070); $_1509124061= ___1030476461(11).$GLOBALS['____700095446'][6]($GLOBALS['____700095446'][7](___1030476461(12))); $_955353417= $GLOBALS['____700095446'][8](___1030476461(13), $_55725607, $_1509124061, true); if($GLOBALS['____700095446'][9]($_955353417, $_367815790) !== min(160,0,53.333333333333)) $_55725607= round(0+6+6); if($_55725607 != min(234,0,78)){ $_70991144= $GLOBALS[___1030476461(14)]->Query(___1030476461(15), true); if($_1727003830= $_70991144->Fetch()){ if($GLOBALS['____700095446'][10]($_1727003830[___1030476461(16)])> $_55725607) $GLOBALS['____700095446'][11](array($GLOBALS[___1030476461(17)], ___1030476461(18)));}}}}/**/
		foreach (GetModuleEvents("main", "OnBeforeLocalRedirect", true) as $event)
		{
			ExecuteModuleEventEx($event, [&$url, $this->isSkippedSecurity(), &$isExternal]);
		}

		if (!$isExternal)
		{
			$url = $this->processInternalUrl($url);
		}

		$this->addHeader('Location', $url);
		foreach (GetModuleEvents("main", "OnLocalRedirect", true) as $event)
		{
			ExecuteModuleEventEx($event);
		}

		$_SESSION["BX_REDIRECT_TIME"] = time();

		parent::send();
	}
}