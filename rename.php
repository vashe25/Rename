<?php
/**
 * Created by PhpStorm.
 * User: laptop
 * Date: 30.07.2015
 * Time: 23:40
 */

class Kernel {
    function __construct(){
        echo "Kernel initialised...\n";
    }
    //����� ����� ��� ����������
    public $pattern = "*.txt";
    //������� ����������, � ������� ����������� ������
    public $current_dir = "./";
    //Name of csv-file
    private $file_csv = "rename.csv";
    //searching for files
    public function scanFor(){
        //���������� ��������
        $dir_handle = opendir($this->current_dir);
        //�������� ������ ��������� ��������
        $array = scandir($this->current_dir);
        //Create array for filtered elements
        $filtered_files = array();
        //������ � ������� ���� �����
        foreach ($array as $item){
            if (fnmatch($this->pattern, $item)){
                //�������� ����� ������� � ���������
                $filtered_files[] = $item;
            }
        }
        //Filtered Array
        return $filtered_files;
        //
    }
    public function createFile($filtered_files){
        //������� CSV-�����
        $massive_csv = array();
        //add second column
        foreach ($filtered_files as $item){
            $massive_csv[] = $item . ";newname.txt\n";
        }
        //
        //�������� ���� CSV-�����
        //Gluing array to string
        $string_csv = implode("",$massive_csv);
        //Writing string to file
        $fp = fopen($this->file_csv, "w");
        fwrite($fp, $string_csv);
        fclose($fp);
        return TRUE;
        //
    }
    public function readFile(){
        //Reading CSV-file
        $fp = fopen($this->file_csv, "r");
        $i = 0;
        while (($array_csv[$i] = fgetcsv($fp, 0,";")) !== FALSE) {
            $i++;
        }
        fclose($fp);
        /*
            Array[0]->header
            Array[1][0]->oldName
            Array[1][1]->newName
        */
        return $array_csv;
        //
    }
    public function openFile(){
        //������� ��� �������������� ������������� CSV-�����
        exec($this->file_csv);
        //
    }
    public function reName($array){
        /**
         * ����� ���������� ������ ������ ������
         */
        foreach ($array as $value){
            rename($value[0], $value[1]);
        }
    }
    public function rollBack($array){
        foreach ($array as $value){
            rename ($value[1], $value[0]);
        }
    }
    public function deleteFile(){
        unlink($this->file_csv);
    }
}

$tool = new Kernel();

isset($argv[1]) ? $parameter = $argv[1] : $parameter = NULL;

switch ($parameter){
    case 'find':
        if (isset($argv[2])){
            $tool->pattern = "*." . $argv[2];
        }
        $array = $tool->scanFor();
        $tool->createFile($array);
        $tool->openFile();
        break;

    case 'rename':
        $array = $tool->readFile();
        $tool->reName($array);
        break;

    case 'rollback':
        $array = $tool->readFile();
        $tool->rollBack($array);
        break;

    case 'kill':
        $tool->deleteFile();
        break;

    default:
        echo "  Greetings, Commander!\n";
        echo "Here is a guide about control parameters:\n";
        echo "find pdf - this will find all pdf files in current location\n";
        echo "rename - reads the csv file, and renames all files\n";
        echo "rollback - renames backward\n";
        echo "kill - is for deleting garbage\n";
        echo "  Good luck, Commander!\n";
        break;
}