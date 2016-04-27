<?php

$link = "http://moscow.megafon.ru/services/21";

$useragent = "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.87 Safari/537.36";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $link); //set link
curl_setopt($ch, CURLOPT_USERAGENT, $useragent); //useragent
curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE); //no cache
curl_setopt($ch, CURLOPT_MAXREDIRS, 3); //limit to redirects
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE); //follow to new location
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); //response to string
curl_setopt($ch, CURLOPT_HEADER, TRUE); //include header
curl_setopt($ch, CURLOPT_NOBODY, TRUE); //exclude body
$str = curl_exec($ch); //send request
curl_close($ch);


$fp = fopen("dump.txt", "w");
fwrite($fp, $str);
fclose($fp);

?>