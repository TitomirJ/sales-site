<?php
namespace App;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class Ukrpost
{
const CULTURE_EN = 'en';
const CULTURE_UA = 'uk';
const URL_PATTERN = 'http://services.ukrposhta.ua/barcodestatistic/barcodestatistic.asmx/GetBarcodeInfo?guid=1&barcode=%s&culture=%s';
private $client;
public function __construct()
{
$this->client = new GuzzleClient();
}
public function GetBarcodeInfo($barcode, $lang = self::CULTURE_EN)
{
try {
$result = $this->client->get(sprintf(self::URL_PATTERN, $barcode, $lang));
return $this->xmlToArray($result->getBody());
} catch (\Exception $e) {
return [
'error' => $e->getMessage()
];
}
}
private function xmlToArray($xmlString)
{
return (array)simplexml_load_string($xmlString);
}
}