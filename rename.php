<?php
/**
 * Created by PhpStorm.
 * User: laptop
 * Date: 30.07.2015
 * Time: 23:40
 */

class Kernel {
    function __construct(){

        echo "Kernel->start\n\n";

    }
    //Какие файлы нас интересуют
    public $pattern = "*.txt";
    //Текущая директория, в которой запускается скрипт
    public $current_dir = "./";
    //Name of csv-file
    private $file_csv = "rename.csv";
    //For dir structure
    private $file_dir = "folder.txt";
    //searching for files
    public function scanFor(){
        //Дескриптор каталога
        $dir_handle = opendir($this->current_dir);
        //Получаем массив элементов каталога
        $array = scandir($this->current_dir);
        //Create array for filtered elements
        $filtered_files = array();
        //Поищем в массиве нашы файлы
        foreach ($array as $item){
            if (fnmatch($this->pattern, $item)){
                //Найденые файлы соберем в массивчик
                $filtered_files[] = $item;
            }
        }
        //Filtered Array
        return $filtered_files;
        //
    }
    public function createFile($filtered_files){
        //Соберем CSV-шечку
        $massive_csv = array();
        //Добавляем вторую колонку
        foreach ($filtered_files as $item){
            $massive_csv[] = $item . ";newname.txt\n";
        }
        //
        //Сохраним нашу CSV-шечку
        //Склеиваем массив в строки
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
            Array[1][0]->oldName
            Array[1][1]->newName
        */
        //Удаляем последний элемент массива, так как он пустой
        unset ($array_csv[$i]);
        return $array_csv;
        //
    }
    public function openFile(){
        //Откроем для редактирования пользователем CSV-шечку
        exec($this->file_csv);
        //
    }
    /**
     * @param $array
     */
    public function reName($array){
        //Создадим пустой массив, в котором будем хранить
        //директории (строки)
        $array_uniq = array();
        //Отрезаем имя файла в конце строки элемента массива
        foreach ($array as $value) {
            $array_uniq[] = dirname($value);
        }
        //Удаляем повторяющиеся значения в массиве
        $array_uniq = array_unique($array_uniq);
        //Находим ключ элемент массива со значением "."
        $del = array_search(".", $array_uniq);
        //Удаляем элемент массива со значением "."
        unset($array_uniq[$del]);
        //Если массив оказался  не пустым, то в цыкле создаём
        //необходимые директории для того, что бы положить
        //туда всё файлы, которые будем переименовывать ниже
        if (!empty($array_uniq)) {
            foreach ($array_uniq as $value) {
                //Создаём папку и пишем результат в консоль
                mkdir($value, 0777, true);
                echo "Created folder: " . $value . "\n";
            }
        }

        foreach ($array as $value){
            if (rename($value[0], $value[1])){
                echo "Done: ";
            }
            echo $value[0] . " -> " . $value[1] . "\n";
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

    public function folderCreate(){
        if (file_exists($this->current_dir . $this->file_dir)) {
            ///!!!!!!!
        }
    }
}

//Выставляем UTF-8 в консоли
//`chcp 65001`;

//Выставляем UTF-8 в консоли
`chcp 1251`;

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

    case 'folder':
        # code...
        break;

    default:
        echo "  Greetings, Commander!\n";
        echo "Here is a guide about control parameters:\n";
        echo "> find pdf - this will find all pdf files in current location\n";
        echo "> rename - reads the csv file, and renames all files\n";
        echo "> rollback - renames backward\n";
        echo "> kill - is for deleting garbage\n\n";
        echo "---> Example:\n";
        echo "php \$script_path/rename.php find pdf\n find all *.pdf files in current folder and create a *.csv file\n\n";
        echo "---> Recomended format for newName.pdf:\n\n";
        echo "./folder/newName.pdf\n";
        echo "./newName.pdf\n";
        echo "\n";
        echo "  Good luck, Commander!\n";
        break;
}
echo "\nKernel->exit\n";