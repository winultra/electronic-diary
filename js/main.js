$(document).ready(function () {
    $('form#post-noimage').each(function(){
        $(this).on('submit', (function(e){
            $('.preloader').css('background', 'rgba(255, 255, 255, .7)').show();
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "action/post_core.php",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function (norest) { $('.preloader').css('background', 'rgba(255, 255, 255, .7)', 'display', 'block').show(); },
                success: function (res) {
                    var jsonp = JSON.parse(res);
                    if (jsonp['seccess'] === undefined) {
                        if (jsonp['error'] == 'obradmin') { alert('Не заполнены все поля авторизации!'); }
                        if (jsonp['error'] == 'nologinpass') { alert('Логин или пароль не совпадают!'); }
                        if (jsonp['error'] == 'ernodata') { alert('Не все поля заполнены!'); }
                        if (jsonp['error'] == 'ernopasrepass') { alert('Пароли не совападают!'); }
                        if (jsonp['error'] == 'ernooldpass') { alert('Не верный старый пароль!'); }
                        if (jsonp['error'] == 'errorNovalidEmail') { alert('Не правиль вид Адреса!'); }
                    } else if (jsonp['error'] === undefined) {
                        if (formData.getAll('operation') == 'add_lesson') {
                            alert('Занятие добавлено');
                            location.reload('/el');
                        } else if (formData.getAll('operation') == 'chang_pass') {
                            alert('Ваш пароль изменен!');
                            location.reload();
                        } else if (formData.getAll('operation') == 'edit_lesson') {
                            console.log('Save');
                        } else { location.reload('/el'); }
                    }else{ alert('Обратитесь к администратору, Ошибка авторизации 2'); }
                    $('.preloader').css('background', '#FFF').hide();
                },
                error: function () {
                    alert('Обратитесь к администратору, Ошибка авторизации 3');
                    $('.preloader').css('background', '#FFF').hide();
                }
            });
        }));
    });
});
$(".profile").click(function () {
    $('.arProfile').toggleClass("open");
    $('.wrapmenuprofile').toggleClass("open");
});
function isEmpty(str) {
    if (str.trim() == '')
        return true;

    return false;
}
function loadingdata(polozh) {
    if (polozh == 'on') { $('.preloader').css('background', 'rgba(255, 255, 255, .7)').show(); }
    else { $('.preloader').css('background', '#FFF').hide(); }
}
function exituser() {
    loadingdata('on');
    $.ajax({
        url: "action/loadinfo.php",
        type: "POST",
        data: { operation: "exit" },
        dataType: "html",
        success: function (res) {
            var jsonp = JSON.parse(res);
            if (jsonp['seccess'] === undefined) {
                location.reload('/el');
            } else if (jsonp['error'] === undefined) {
                location.reload('/el'); // window.location.reload()
            } else { alert('Обратитесь к администратору, Ошибка авторизации 2'); }
            loadingdata('off');
        },
        error: function (er) {
            alert('Обратитесь к администратору, Ошибка авторизации 3');
            loadingdata('off');
        }
    })
}
function loaddaylesson(data, elm = null) {
    loadingdata('on');
    $('.weekend-day').removeClass('activepoint');
    if (elm != null) { elm.classList.add('activepoint'); }
    $.ajax({
        url: "action/loadinfo.php",
        type: "POST",
        data: { operation: "loaddaylesson", data: data },
        dataType: "html",
        success: function (res) {
            if (isEmpty(res) == false) {
                var jsonp = JSON.parse(res);
                $('.tbodytablehomwork').empty();
                $('.wrappeMobileInterface').empty();
                for (var i = 0; i < jsonp.length; i++) {
                    if (jsonp[i]['kek'] == 'yes') {
                        $('.tbodytablehomwork').append('<tr><th>' + jsonp[i]['datetime'] + '</th><th>' + jsonp[i]['title'] + ' / ' + jsonp[i]['lesson'] + '</th><th>' + jsonp[i]['point'] + '</th><th class="homwork_' + i + '"><span class="hmw_edittxt_' + i + '">' + jsonp[i]['homework'] + '</span><i class="icoedit" onclick="edit_hmwk_start(' + i + ',' + jsonp[i]['idless'] + ');" title="редактировать домашине задание"></i></th></tr>');
                        $('.wrappeMobileInterface').append('<div class="wraplesson"><div class="titleLesson">' + jsonp[i]['lesson'] + '</div><div class="titleLesson_tema">' + jsonp[i]['title'] + '</div><div class="timelesson">' + jsonp[i]['datetime'] + '</div><div class="homeworkLesson">' + jsonp[i]['homework'] + '</div></div>');
                    } else {
                        $('.tbodytablehomwork').append('<tr><th>' + jsonp[i]['datetime'] + '</th><th>' + jsonp[i]['title'] + ' / ' + jsonp[i]['lesson'] + '</th><th>' + jsonp[i]['point'] + '</th><th>' + jsonp[i]['homework'] + '</th></tr>');
                        $('.wrappeMobileInterface').append('<div class="wraplesson"><div class="titleLesson">' + jsonp[i]['lesson'] + '</div><div class="titleLesson_tema">' + jsonp[i]['title'] + '</div><div class="timelesson">' + jsonp[i]['datetime'] + '</div><div class="homeworkLesson">' + jsonp[i]['homework'] + '</div></div>');
                    }

                }
            } else {
                $('.tbodytablehomwork').empty(); $('.tbodytablehomwork').append('<tr><th colspan="4">Занятия отсутсвуют</th></tr>');
                $('.wrappeMobileInterface').empty(); $('.wrappeMobileInterface').append('<div class="wraplesson" style="text-align:center;">Занятия отсутсвуют</div>');
            }
            loadingdata('off');
        },
        error: function (er) {
            d
            alert('Обратитесь к администратору, Ошибка авторизации 3');
            loadingdata('off');
        }
    })
}
function loaddaylessonWeek(oper, deta) {
    loadingdata('on');
    $.ajax({
        url: "action/loadinfo.php",
        type: "POST",
        data: { operation: "loaddaylessonWeek", action: oper, deta: deta },
        dataType: "html",
        success: function (res) {
            if (isEmpty(res) == false) {
                var jsonp = JSON.parse(res);
                $('.titlemoth').hide('right');
                $('.pagination-moth').empty().append(jsonp['pagination-moth']);
                $('.titlemoth').show('top');
                $('.homework-user').empty().append(jsonp['homework-user']);
            } else { alert('Обратитесь к администратору, Ошибка!'); }
            loadingdata('off');
        },
        error: function (er) {
            d
            alert('Обратитесь к администратору, Ошибка авторизации 3');
            loadingdata('off');
        }
    })
}