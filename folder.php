<?php
/*
	Folder creator //
*/
$array = array (
	"./action/tp_all_inc_xs/",
	"./all_inclusive/",
	"./archive/",
	"./go_to_zero/",
	"./pdf/vse_vklucheno/",
	"./pdf_tariffs/warm_welcome/",
	"./tarif/",
	"./vse_prosto/"
	);

foreach ($array as $folder) {
	mkdir($folder, 0777, true);
	echo "Done: $folder\n";
}
?>