<!DOCTYPE html>
<html>
<head>
    <title>Поиск и отображение файлов в локальной директории</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>

    <link type="text/css" href="/css/style.css" rel="stylesheet" />
    <link type="text/css" href="/css/jqueryFileTree.css" rel="stylesheet" media="screen" />

    <script type="text/javascript" src="/js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="/js/jquery.easing.js"></script>
    <script type="text/javascript" src="/js/jqueryFileTree.js"></script>

    <script type="text/javascript" src="/js/script.js"></script>
</head>
<body>
<h1>Поиск файлов в директории &laquo;<%docroot%>&raquo;</h1>
<div class="blockLeft">
    <div id="blockTree"></div>
</div>

<div class="blockRight">

    <div class="bl_search">
        <div class="search_path">Область поиска: <span><%docroot%></span></div>
        <form method="POST" ID="formDr" action="">
            <input class="search_input" type="text" value="Поиск" ID="searchDr" name="filename" defvalue="Поиск">
            <input class="search_go" type="submit" value="">
        </form>
        <div class="small">Можно использовать знак вопроса (?) в качестве подстановки для одного знака и звездочку (*) в качестве подстановки для любого количества знаков (например, *.doc, mydoc.*, my*.doc, test?.* и т.п.).</div>
    </div>
    <div class="blockRight_sub">
        <h2>Результаты поиска:</h2>
        <div class="search_path">Поиск в: <span><%docroot%></span></div>
        <div id="blockResult"></div>
    </div>
</div>
<div class="cl"></div>
<div class="popup_block"></div>
<div id="back"></div>

</body>
</html>