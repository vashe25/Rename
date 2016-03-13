<?php
`chcp 65001`;

$links = array(
	"http://astrakhan.megafon.ru/tariffs/alltariffs/all_inclusive/all_inclusive_xs/xs.html",
	"http://volgograd.megafon.ru/tariffs/alltariffs/all_inclusive/all_inclusive_xs/xs.html",
	"http://orenburg.megafon.ru/tariffs/alltariffs/all_inclusive/all_inclusive_xs/xs.html",
	"http://penza.megafon.ru/tariffs/alltariffs/all_inclusive/all_inclusive_xs/xs.html",
	"http://bashkortostan.megafon.ru/tariffs/alltariffs/all_inclusive/all_inclusive_xs/xs.html",
	"http://kalmykia.megafon.ru/tariffs/alltariffs/all_inclusive/all_inclusive_xs/xs.html",
	"http://mariel.megafon.ru/tariffs/alltariffs/all_inclusive/all_inclusive_xs/xs.html",
	"http://mordovia.megafon.ru/tariffs/alltariffs/all_inclusive/all_inclusive_xs/xs.html",
	"http://tatarstan.megafon.ru/tariffs/alltariffs/all_inclusive/all_inclusive_xs/xs.html",
	"http://samara.megafon.ru/tariffs/alltariffs/all_inclusive/all_inclusive_xs/xs.html",
	"http://saratov.megafon.ru/tariffs/alltariffs/all_inclusive/all_inclusive_xs/xs.html",
	"http://ulyanovsk.megafon.ru/tariffs/alltariffs/all_inclusive/all_inclusive_xs/xs.html",
	"http://chuvashia.megafon.ru/tariffs/alltariffs/all_inclusive/all_inclusive_xs/xs.html",
);

$context = stream_context_create(
	array(
		"http" => array(
			"method" => "GET",
			"protocol_version" => "1.1",
			"headers" => array(
				'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:24.0) Gecko/20100101 Firefox/24.0',
				//'Cookie: foo=bar\r\n',
				'Connection: close',
				),
			)
		)
	);

$stream = fopen('http://astrakhan.megafon.ru/tariffs/alltariffs/all_inclusive/all_inclusive_xs/xs.html', 'r', false, $context);

if ($stream) {
	echo "streaming";
	
	$page = stream_get_contents($stream); //page content
	$data = stream_get_meta_data($stream); //headers

	var_dump($data);
	fclose($stream);

} else {
	echo "no stream";
	$page[] = "Error: Failed to open stream";
}

exit;

/**
* Link Finder
*/
class linkFinder 
{
	
	function __construct(argument)
	{
		# code...
	}

	public $context = stream_context_create(
		array(
			"http" => array(
				"method" => "GET",
				"protocol_version" => "1.1",
				"headers" => array(
					'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:24.0) Gecko/20100101 Firefox/24.0',
					//'Cookie: foo=bar\r\n',
					'Connection: close',
					),
				)
			)
		);

	

}















foreach ($links as $link) {
	
	$pages[$link] = file_get_contents($link) or "fail";

}

$pattern = "{\".+\.pdf\"}";

$matches = array();

foreach ($pages as $link => $page) {
	
	preg_match($pattern, $page, $matches[$link]);

}


foreach ($matches as $link => $match) {
	
	$string .= $link . "\r\n";

	foreach ($match as $value) {

		$string .= "	" . trim($value,'"') . "\r\n";

	}
	
}

$fp = fopen("finderlog.txt", "w");

fwrite($fp, $string);

fclose($fp);

//var_dump($matches);
