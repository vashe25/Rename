<?php
/**
 * Created by PhpStorm.
 * User: laptop
 * Date: 30.07.2015
 * Time: 23:40
 */
$param_array = getopt("",$argv);

$file_csv = "rename.csv";
$fp = fopen($file_csv, "r");
$i = 0;
while ($i < 10) {
    $array_csv[$i] = fgetcsv($fp, "",";");
    $i++;
}

fclose($fp);
var_dump($array_csv);
/*/
switch ($param_array["1"]) {
	case 'rename':
        $file_csv = "rename.csv";
		$fp = fopen($file_csv, "r");
        $array_csv = fgetcsv($fp, "",";");
        fclose($fp);
        var_dump($array_csv);
		break;

	default:
		echo "parameters fo script:\n";
		echo "rename - is for renaming files.\n";
		break;
}
//
//������� ����������, � ������� ����������� ������
$current_dir = "./";

//����� ����� ��� ����������
$pattern = "*.txt";

//���������� ��������
$dir_handle = opendir($current_dir);

//�������� ������ ��������� ��������
$array = scandir($current_dir);

$filtered_files = array();

//������ � ������� ���� �����
foreach ($array as $item){
    if (fnmatch($pattern, $item)){
        //�������� ����� ������� � ���������
        $filtered_files[] = $item;
    }
}

//������� CSV-�����
$header_csv = "OldName;Newname\n";

$massive_csv[] = $header_csv;

foreach ($filtered_files as $item){
    $massive_csv[] = $item . ";newname.txt\n";
}
//
//�������� ���� CSV-�����
$file_csv = "rename.csv";

$string_csv = implode("",$massive_csv);

$fp = fopen($file_csv, "w");
fwrite($fp, $string_csv);
fclose($fp);
//
//������� ��� �������������� ������������� CSV-�����
//exec($file_csv);
/*/