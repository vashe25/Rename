<?php

`chcp 65001`;

$rssObj = simplexml_load_file("http://news.rambler.ru/rss/Moscow/");

$detailText = array();

foreach ($rssObj->channel->item as $item) {

	$page = file_get_contents($item->link);

	$pattern = "{article__inner(.*)\">}";

	preg_match($pattern, $page, $detailText);

	$item['detailText'] = strip_tags($detailText);

	//$fp = fopen("newsDetail_" . $item->guid, "w");

	//fwrite($fp, $string);

	//fclose($fp);

}

var_dump($rssObj->channel->item);