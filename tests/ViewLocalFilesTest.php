<?php
/**
 * Class ViewLocalFiles
 * @author Елена Орешкина <elena.graneva@gmail.com>
 */

include_once __DIR__ . '/../common/func.php';


class ViewLocalFilesTest extends PHPUnit_Framework_TestCase {

    private $_class = null;
    public function setUp()
    {
        $this->_class = new ViewLocalFiles();
    }

    public function tearDown()
    {
        $this->_class = null;
    }

    /**
     * Если директория задана неверно, то массив с элементами дерева не должен быть построен
     * @covers ViewLocalFiles::getListChildren
     * @uses ViewLocalFiles
     */
    public function testEmptyArrForNotValidDirectory()
    {
        $arr = $this->_class->getListChildren(__DIR__.'/../NotExists/');
        $this->assertEmpty($arr);
    }

    /**
     * Если директория верная, должен выдаваться массив с данными дерева
     * @covers ViewLocalFiles::getListChildren
     * @uses ViewLocalFiles
     */
    public function testValidDirectoryPathForBuildTree()
    {
        $arr = $this->_class->getListChildren(__DIR__.'/../');
        $this->assertTrue(is_array($arr));
    }

    /**
     * Корректен ли JSON, есть ли в нем указание на директорию 'dir', если вложенные директории существуют
     * @covers ViewLocalFiles::getListChildren
     * @uses ViewLocalFiles
     * @depends testValidDirectoryPathForBuildTree
     */
    public function testValidJsonForBuildTree()
    {
        $arr = $this->_class->getListChildren(__DIR__.'/../');
        $json = json_encode($arr, true);
        $this->assertRegExp('/"dir":1/',$json);
    }

    /**
     * Если файла не существует, то должен вернуться пустой результат
     * @covers ViewLocalFiles::getFileInformation
     * @uses ViewLocalFiles
     */
    public function testValidFileNotExists()
    {
        $json = $this->_class->getFileInformation(__DIR__.'/../NotExist.php');
        $this->assertEmpty($json);
    }

    /**
     * Если файл существует, то должен вернуться не пустой результат
     * @covers ViewLocalFiles::getFileInformation
     * @uses ViewLocalFiles
     */
    public function testValidFileExists()
    {
        $json = $this->_class->getFileInformation(__DIR__.'/../index.php');
        $this->assertNotEmpty($json);
    }

    /**
     * Корректен ли JSON с информацией о файле
     * @covers ViewLocalFiles::getFileInformation
     * @uses ViewLocalFiles
     * @depends testValidFileExists
     */
    public function testValidJsonForFileInfo()
    {
        $json = $this->_class->getFileInformation(__DIR__.'/../index.php');
        $arr = json_decode($json,true);
        $this->assertTrue(is_array($arr));
        $this->assertArrayHasKey('name', $arr);
        $this->assertEquals('index.php', $arr['name']);
    }

    /**
     * Неверная маска для фильтра файлов в поиске
     * @covers ViewLocalFiles::getSearchInfo
     * @uses ViewLocalFiles
     */
    public function testNotValidMaskForSearching()
    {
        $arr = $this->_class->getSearchInfo('*sj32?-/\/.php',__DIR__.'/../');
        $this->assertEmpty($arr);
    }

    /**
     * Верная маска для фильтра файлов в поиске
     * @covers ViewLocalFiles::getSearchInfo
     * @uses ViewLocalFiles
     */
    public function testValidMaskForSearching()
    {
        $arr = $this->_class->getSearchInfo('*.class',__DIR__.'/../classes/');
        $this->assertTrue(is_array($arr));
        $this->assertCount(2, $arr);
    }

    /**
     * Неверная директория для поиска файлов
     * @covers ViewLocalFiles::getSearchInfo
     * @uses ViewLocalFiles
     */
    public function testNotValidPathForSearching()
    {
        $arr = $this->_class->getSearchInfo('*.php',__DIR__.'/../NotExists/');
        $this->assertEmpty($arr);
    }

    /**
     * Верная директория для поиска файлов
     * @covers ViewLocalFiles::getSearchInfo
     * @uses ViewLocalFiles
     */
    public function testValidPathForSearching()
    {
        $arr = $this->_class->getSearchInfo('*.php',__DIR__.'/../common/');
        $this->assertTrue(is_array($arr));
        $this->assertCount(1, $arr);
    }

    /**
     * Корректен ли JSON с информацией о найденных файлах
     * @covers ViewLocalFiles::getSearchInfo
     * @uses ViewLocalFiles
     * @depends testValidPathForSearching
     */
    public function testValidJsonForSearching()
    {
        $arr = $this->_class->getSearchInfo('*.php',__DIR__.'/../common/');
        $json = json_encode($arr, true);
        $this->assertRegExp('/func\.php/',$json);
    }

}
 