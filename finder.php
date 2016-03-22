<?php
/**
* Finder
*/
class Finder 
{
	
	function __construct()
	{
		if (isset($argv[1])) {
			$this->pattern = $argv[1];
		}
	}
	//file for links
	public $linksFile = "links.txt";
	//array of links
	public $linksArray = array("http://moscow.megafon.ru/");
	//regexp pattern
	public $pattern = "href=\"(.+\.pdf)\"";
	//all pages content
	public $pages = array();
	//array for all finded matches
	public $matches = array();
	//filename for writing result
	public $logFile = "log_LF.txt";

	public function loadFile() {
		if (file_exists($this->linksFile)) {
			$this->linksArray = file($this->linksFile, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
			return TRUE;
		} else {
			$fp = fopen($this->linksFile, "w");
			$string = "http://moscow.megafon.ru/";
			fwrite($fp, $string);
			fclose($fp);
			return FALSE;
		}
	}

	public function getPage()
	{
		foreach ($this->linksArray as $link) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $link);
			curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			$this->pages[$link] = curl_exec($ch);
			curl_close($ch);
		}
	}

	public function findPattern()
	{
		$pattern = "{" . $this->pattern . "}";
		foreach ($this->pages as $link => $content) {
			preg_match_all($pattern, $content, $this->matches[$link], PREG_SET_ORDER);
		}
	}

	public function printResult()
	{	
		$string = "Finded results:\r\n\r\n";
		foreach ($this->matches as $link => $match) {
			$string .= $link . "\r\n";
			if ($match) {
				foreach ($match as $value) {
					$string .= "	" . $value[0] . "\r\n";
				}
			} else {
				$string .= "	" . "NOTHING" . "\r\n";
			}
		}
		$fp = fopen($this->logFile, "w");
		fwrite($fp, $string);
		fclose($fp);
	}

	public function run()
	{
		if ($this->loadFile()) {
			$this->getPage();
			$this->findPattern();
			$this->printResult();
			echo "Check results in: " . $this->logFile . "\r\n";
		} else {
			echo "Write links in: " . $this->linksFile . "\r\n";
		}
	}
}

$LF = new Finder();

$LF->run();
