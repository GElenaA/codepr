<?php
/**
 * func.php - Подключает настройки и сожержит фукнции
 *
 * @author Елена Орешкина <elena.graneva@gmail.com>
 */

/**
 * Основные настройки
 */
include_once __DIR__ . '/defines.ext';

/**
 * Поключаем имеющиеся в системе классы
 */
spl_autoload_register("myAutoload");

/**
 * myAutoload - подключение всех классов из папки /classes/
 * @var className - Имя класса без расширения
 */
function myAutoload ($className)
{
    $filePath = __DIR__ . '/../classes/' . $className . '.class';
    if (file_exists($filePath))
    {
        require_once $filePath;
    }
}

?>