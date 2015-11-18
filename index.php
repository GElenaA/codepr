<?php
/**
 * index.php - Основной скрипт для запуска сервиса по отображению директорий и файлов на локальном компьютере
 *
 * Задание:
 * Создать класс на PHP без использования фреймворков для поиска и отображения файлов в локальной директории.
 * Покрыть код тестами PHPUnit.
 * Продемонстрировать пример использования класса.
 * Покрыть использлвание тестами Selenium.
 *
 * @author Елена Орешкина <elena.graneva@gmail.com>
 */

/**
 * Подключение настроек и функций, автозагрузчик классов
 */
include_once __DIR__ . '/common/func.php';
/**
 * Подключение класса для работы с файловой системой
 */
$viewer = new ViewLocalFiles;

if($_SERVER["REQUEST_METHOD"]=="POST" && !empty($_POST['dir'])) {
    if(!empty($_POST['val'])){
        /**
         * Поиск по заданному условию
         */
        $viewer->getSearchInfo(urldecode($_POST['val']),urldecode($_POST['dir']));
    }else{
        /**
         * Отображение вложенных директорий и файлов в текущей папке
         */
        $viewer->getListChildren(urldecode($_POST['dir']));
    }

}elseif($_SERVER["REQUEST_METHOD"]=="POST" && !empty($_POST['filen'])) {
    /**
     * Получение информации о файле
     */
    $viewer->getFileInformation(urldecode($_POST['filen']));
}else{

    /**
     * @var arr - массив с мета-данными для основного шаблона /templates/main.tpl
     * @var arr['docroot'] - путь на сервере
     */
    $arr = Array();
    $arr["docroot"] = DOCROOT;
    /**
     * Вывод на экран данных основного шаблона
     */
    $template = new Template($arr,'main');
    $template->display();
}
?>