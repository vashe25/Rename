<?php
`chcp 65001`;

/**
* Link Finder
*/
class linkFinder 
{
	
	function __construct()
	{
		
	}

	public $linksFile = "links.txt";

	public function loadFile($filename = "links.txt") {
		if (file_exists($filename)) {
			$array = file($filename, FILE_SKIP_EMPTY_LINES);
			return $array;
		} else {
			$fp = fopen($filename, "w");
			$string = "http://moscow.megafon.ru/";
			fwrite($fp, $string);
			fclose($fp);
			return FALSE;
		}
	}

	public function getPage($array = array("http://moscow.megafon.ru/"))
	{
		$pages = array();
		$ch = curl_init();
		foreach ($array as $link) {
			curl_setopt($ch, CURLOPT_URL, $link);
			curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			$pages[$link] = curl_exec($ch);
		}
		curl_close($ch);
		return $pages;
	}

	public function findPattern($pages = array(), $pattern = "\".+.pdf\"")
	{
		$pattern = "{" . $pattern . "}";
		$matches = array();
		foreach ($pages as $link => $content) {
			preg_match_all($pattern, $content, $matches[$link], PREG_SET_ORDER);
		}
		return $matches;
	}

	public function printResult($matches = array())
	{	
		$string = "Finded results:\r\n\r\n";
		foreach ($matches as $link => $match) {
			$string .= $link . "\r\n";
			foreach ($match as $value) {
				$string .= "	" . $value . "\r\n";
			}
		}
		$fp = fopen("finderlog.txt", "w");
		fwrite($fp, $string);
		fclose($fp);
	}
}


$Obj = new linkFinder();


if ($links = $Obj->loadFile())
{
	$pages = $Obj->getPage($links);

	$matches = $Obj->findPattern($pages);
	var_dump($matches);
	exit;
	$Obj->printResult($matches);
}