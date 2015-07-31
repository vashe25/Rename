<?php
/**
 * Created by PhpStorm.
 * User: laptop
 * Date: 30.07.2015
 * Time: 23:40
 */
//������� ����������, � ������� ����������� ������
$current_dir = "./";

//����� ����� ��� ����������
$pattern = "*.txt";

//���������� ��������
$dir_handle = opendir($current_dir);

//�������� ������ ��������� ��������
$array = scandir($current_dir);

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

//�������� ���� CSV-�����
$file_csv = "rename.csv";

$string_csv = implode("",$massive_csv);

$fp = fopen($file_csv, "w");
fwrite($fp, $string_csv);
fclose($fp);

//������� ��� �������������� ������������� CSV-�����
exec($file_csv);