<?php
require "vendor/autoload.php";

use GuzzleHttp\Client;

$tariffsArray = array(
	"3D-общение" => array("url" => "/tariffs/alltariffs/archive/3d-obschenie/"),
	"Агент 009" => array("url" => "/tariffs/alltariffs/archive/agent_009/"),
	"Арифметика (до 10.12.2009)&#8203;" => array("url" => "/tariffs/alltariffs/archive/arifmetika2/"),
	"Арифметика (с 10.12.2009 по 01.03.2010)&#8203;" => array("url" => "/tariffs/alltariffs/archive/arifmetika1/"),
	"Арифметика (с 01.03.2010)" => array("url" => "/tariffs/alltariffs/archive/arifmetika/"),
	"Бесплатные звонки" => array("url" => "/tariffs/alltariffs/archive/besplatnye_zvonki/"),
	"Домашний плюс" => array("url" => "/tariffs/alltariffs/archive/domashniy_plyus/"),
	"Драйв плюс" => array("url" => "/tariffs/alltariffs/archive/drayv_plyus/"),
	"Драйв" => array("url" => "/tariffs/alltariffs/archive/drayv/"),
	"Любимый край" => array("url" => "/tariffs/alltariffs/archive/lyubimyy_kray/"),
	"Любимый край 2012" => array("url" => "/tariffs/alltariffs/archive/lyubimyy_kray_2012/"),
	"Максимальный" => array("url" => "/tariffs/alltariffs/archive/maksimalnyy/"),
	"МегаФон&nbsp;— Все включено L 2012" => array("url" => "/tariffs/alltariffs/archive/megafon_vse_vklyucheno_l/"),
	"МегаФон&nbsp;— Все включено M 2012" => array("url" => "/tariffs/alltariffs/archive/megafon_vse_vklyucheno_m/"),
	"МегаФон&nbsp;— Все включено S 2012" => array("url" => "/tariffs/alltariffs/archive/megafon_vse_vklyucheno_s/"),
	"Все просто 2013" => array("url" => "/tariffs/alltariffs/archive/vse_prosto_2013/"),
	"Мобильный" => array("url" => "/tariffs/alltariffs/archive/mobilnyy/"),
	"Переходи на НОЛЬ" => array("url" => "/tariffs/alltariffs/archive/perehodi_na_nol_/"),
	"Переходи на 0 2012" => array("url" => "/tariffs/alltariffs/archive/perehodi_na_0/"),
	"Переходи на НОЛЬ 2014" => array("url" => "/tariffs/alltariffs/archive/perehodi_na_nol1/"),
	"Простор общения" => array("url" => "/tariffs/alltariffs/archive/prostor_obscheniya/"),
	"Родной" => array("url" => "/tariffs/alltariffs/archive/rodnoy/"),
	"Секунда" => array("url" => "/tariffs/alltariffs/archive/sekunda/"),
	"Транзитный" => array("url" => "/tariffs/alltariffs/archive/tranzitnyy/"),
	"Тёплый приём 2013" => array("url" => "/tariffs/alltariffs/archive/tepllyy_priem/"),
	"Тёплый приём 2016" => array("url" => "/tariffs/alltariffs/archive/teplyy_priem_2016/"),
	"Честное слово" => array("url" => "/tariffs/alltariffs/archive/chestnoe_slovo1/"),
	);

$regionsArray = array(
	1 => "http://altay.megafon.ru",
	"http://kem.megafon.ru",
	"http://kras.megafon.ru",
	"http://nsk.megafon.ru",
	"http://omsk.megafon.ru",
	"http://altrep.megafon.ru",
	"http://tyva.megafon.ru",
	"http://hakas.megafon.ru",
	"http://tay.megafon.ru",
	"http://tom.megafon.ru",
	);

$links = array();

foreach ($tariffsArray as $name => $tariff) {
	foreach ($regionsArray as $region) {
		$links[$name][] = $region . $tariff["url"];
	}
}

$Client = new Client();

$pattern = '/<p class=\"b-tariff__col_wide\">(Городской\sномер|Городской)<\/p><p class=\"b-tariff__col_wide\">(.+?)<\/p>/im';

$matches = array();

foreach ($links["3D-общение"] as $link) {

	try {
		$response = $Client->request('GET', $link);
		$content = $response->getBody()->getContents();
	
		if (preg_match_all($pattern, $content, $matches, PREG_SET_ORDER)) {
			var_dump($matches);
			exit;
		} else {
			print 'Error';
		}

	} catch (\Exception $e) {
		print 'Error: ' . $e->getMessage() . "\n";
		continue;
	}
}
