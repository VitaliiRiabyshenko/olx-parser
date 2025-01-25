<?php

namespace App\Http\Services;

use App\Contracts\Parser;
use DOMDocument;
use DOMXPath;

class ParserService implements Parser
{
    public function parser($url)
    {
        $user_agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36';
		$timeout = 120;

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
		curl_setopt($ch, CURLOPT_ENCODING, "");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
		curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
		 
		$headers = array(
			"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8",
			"Accept-Language: ua-UA,ua;q=0.9,en-US;q=0.8,en;q=0.7",
			"Accept-Encoding: gzip, deflate, br",
			"Referer: https://www.google.com/",
		);
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);

        $document = new DOMDocument();

        libxml_use_internal_errors(true);

        $document->loadHTML($result);

        libxml_use_internal_errors(false);

        $xpath = new DOMXPath($document);

        $node = $xpath->query('//*[@id="mainContent"]/div/div[2]/div[3]/div[2]/div[1]/div/div[3]/div/div/h3', $document)->item(0);

        return $node?->textContent;
    }
}