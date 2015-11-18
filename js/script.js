$(document).ready(function () {

    var pth = $('.bl_search .search_path span').text();
    $('#blockTree').html('<div id="fileTree" class="filetree"></div>');
    $('#fileTree').fileTree({ root: pth, script: '/index.php' }, function(file) {
        showFileInfo(file);
    });

    //Форма поиска
    $('.search_input').focus(function () {
        if ($(this).attr('defvalue') == undefined)
            $(this).attr('defvalue', $(this).val());
        if (($(this).attr('blurvalue') == undefined) || ($(this).attr('blurvalue') == $(this).attr('defvalue')))
            $(this).val('');

    }).blur(function () {
        var blurvalue = $(this).val();
        if (blurvalue == '')
            $(this)
                .removeAttr('blurvalue')
                .val($(this).attr('defvalue'));
        else
            $(this).attr('blurvalue', blurvalue);
    }).keypress(function(e) {
        if (e.keyCode==13) {
            $('#formDr').submit();
            return false;
        }
    });

    //Сабмит формы, ищем директории и файлы по введенной строке
    $('#formDr').submit(function () {

        var v = $('#searchDr').val();
        if(!v || v == undefined || v == $('#searchDr').attr('defvalue')){
            $('#blockResult').html('');
            $('.blockRight_sub').hide();
        }else{
            $('.blockRight_sub').show();
            $('#blockResult').html('<img src="/js/images/spinner.gif" width="16" height="16" alt="Load..." />');
            var d = $('.bl_search .search_path span').text();
            $.post('/index.php', { dir: d, val: v }, function(data) {
                var obj = $.parseJSON( data );
                var items = [];
                items.push("<li class='title'><div class='nm'>Имя</div><div class='sz'>Размер</div><div class='pth'>Путь</div></li>");
                $.each(obj, function() {
                    items.push('<li><div class="nm"><a href="#" onClick="return showFileInfo(\'' + this['nameJs'] + '\');">' + this['name'] + '</a></div><div class="sz">' + this['size'] + '</div><div class="pth">' + this['path'] + '</div></li>');
                });
                $('#blockResult').html($('<UL/>', {
                    'class': 'fileList',
                    html: items.join('')})
                );
            });

        }
        return false;
    });

    $('.file').click(function () {
        showFileInfo(file);
    });

    $("div#back").click(function() {
        off();
    });
    $(".popup_block").click(function() {
        off();
    });

    /* функция возвращения нормального цвета фона */
    function off() {
        $('.popup_block').fadeOut("normal");
        $("#back").fadeOut("normal");
    }
});

/*
 Информация о файле
 */
function showFileInfo(file){
    $.post('/index.php', { filen: file }, function(data) {
        $("#back").css("opacity", "0.3");
        $("#back").fadeIn(500);
        var obj = $.parseJSON( data );
        $('.popup_block').html('<h3>' + obj['name'] + '</h3>Путь: <i>' + obj['path'] + '</i><br><br>Расширение: ' + obj['ext'] + '<br>Размер (байт): ' + obj['size'] + '<br>Последнее изменение: ' + obj['date'] + '<br>');
        $(".popup_block").stop(true,true).animate({opacity: "show"}, "slow");
    });
    return false;
}