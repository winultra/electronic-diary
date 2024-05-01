function edit_hmwk_start(numid, idless) {
    var istext = $('.hmw_edittxt_' + numid).html();
    $('.homwork_' + numid).empty().append('<input type="text" name="hmwk_edit" class="default_input hmwk_edit" value="' + istext + '"><i class="icosave" onclick="saveEditHw(' + numid + ',' + idless + ');"></i>');
}
function saveEditHw(numid, idless) {
    loadingdata('on');
    var inputvalhw = $('.hmwk_edit').val();
    $.ajax({
        url: "action/loadinfo.php",
        type: "POST",
        data: { operation: "saveEditHw", idles: idless, inputvalhw: inputvalhw },
        dataType: "html",
        success: function (res) {
            if (isEmpty(res) == false) {
                $('.homwork_' + numid).empty().append('<span class="hmw_edittxt_' + numid + '">' + inputvalhw + '</span><i class="icoedit" onclick="edit_hmwk_start(' + numid + ',' + idless + ');" title="редактировать домашине задание"></i>');
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
function loadInfoteacherlog() {
    var data_loadMoth = $('.loadMoth').val(),
        data_loadYar = $('.loadYar').val(),
        data_subject = $('.subject').val(),
        data_group = $('.group').val();
    if (data_subject != null && data_group != null) {
        loadingdata('on');
        $.ajax({
            url: "action/loadinfo.php",
            type: "POST",
            data: { operation: "loadInfoteacherlog", data_loadMoth: data_loadMoth, data_loadYar: data_loadYar, data_subject: data_subject, data_group: data_group },
            dataType: "html",
            success: function (res) {
                if (isEmpty(res) == false) {
                    $('.tablestyleteachelog').empty().append(res);
                } else { alert('Отсутсвуют данные !'); }
                loadingdata('off');
            },
            error: function (er) {
                alert('Обратитесь к администратору, Ошибка авторизации 3');
                loadingdata('off');
            }
        })
    } else { console.log('Не заполнены все поля!'); }
}
function intogradeusers(day, month, idst, th) {
    var grade = $(th).html(),
        inclcik = $(th).attr('onclick');
    $(th).removeAttr('onclick');
    $(th).empty().append('<input class="inputeditgrade" onkeyup="savegradeuser(' + day + ',' + month + ',' + idst + ',this,' + inclcik + ')" type="text" max="10" value="' + grade + '">');
}
function savegradeuser(day, month, idst, th = this, ock) {
    var vl = $(th).val(),
        yar = $('.loadYar').val(),
        data_subject = $('.subject').val();
    if (day != null && month != null && idst >= 0) {
        if (event.key === "Control") {
            loadingdata('on');
            $.ajax({
                url: "action/loadinfo.php",
                type: "POST",
                data: { operation: "savegradeuser", data_loadMoth: day, month: month, vl: vl, dt_yar: yar, idst: idst, data_subject: data_subject },
                dataType: "html",
                success: function (res) {
                    if (isEmpty(res) == false) {
                        var jsonp = JSON.parse(res);
                        if (jsonp['seccess'] === undefined) {
                            if (jsonp['error'] == 'erNolesson') { alert('В этот день отсутсвует урок!'); }
                            if (jsonp['error'] == 'NoValid') { alert('Ваши данные не валидны!'); }
                            if (jsonp['error'] == 'erNYes') { alert('Н-ка уже стоит'); }
                        } if (jsonp['error'] === undefined) {
                            $(th).remove();
                            if(vl == 0) vl='';
                            $('#day_' + day+'_'+idst).attr('onclick', ock).text(vl);
                        }
                    } else { alert('Отсутсвуют данные !'); }
                    loadingdata('off');
                },
                error: function (er) {
                    alert('Обратитесь к администратору, Ошибка авторизации 3');
                    loadingdata('off');
                }
            })
            return false;
        }
    }
}
function loadInfoListLesson() {
    var data_subject = $('.subject').val(),
        data_group = $('.group').val();
    if (data_subject != null && data_group != null) {
        loadingdata('on');
        $.ajax({
            url: "action/loadinfo.php",
            type: "POST",
            data: { operation: "loadInfoListLesson", data_subject: data_subject, data_group: data_group },
            dataType: "html",
            success: function (res) {
                if (isEmpty(res) == false) {
                    $('.tableUPlistls').empty().append(res);
                } else { alert('Отсутсвуют данные !'); }
                loadingdata('off');
            },
            error: function (er) {
                alert('Обратитесь к администратору, Ошибка авторизации 3');
                loadingdata('off');
            }
        })
    } else { console.log('Не заполнены все поля!'); }
}
function delete_lesson(){
    loadingdata('on');
    $.ajax({
        url:"action/loadinfo.php",
        type:"POST",
        data:{operation:"delete_lesson"},
        dataType: "html",
        success:function(res){
            if (isEmpty(res) == false) {
                var jsonp = JSON.parse(res);
                if (jsonp['seccess'] === undefined) {
                    if (jsonp['error'] == 'errorID') { alert('Ошибка индентификатора урока!'); }
                    if (jsonp['error'] == 'errorAccess') { alert('Ошибка доступа!'); }
                } if (jsonp['error'] === undefined) {
                    location.reload('/el/listlesson');
                }
            } else { alert('Отсутсвуют данные !'); }
            loadingdata('off');
        },
        error: function (er) {
            alert('Обратитесь к администратору, Ошибка авторизации 3');
            loadingdata('off');
        }
    })
}
function load_group_rating(){
    var data_group = $('.group_select').val();
    if(data_group != null) {
        loadingdata('on');
        $.ajax({
            url:"action/loadinfo.php",
            type:"POST",
            data:{operation:"load_group_rating", data_group: data_group },
            dataType:"html",
            success:function (res) {
                if (isEmpty(res) == false) {
                    $('.body_insterInnfo_rating').empty().append(res);
                } else { alert('Отсутсвуют данные !'); }
                loadingdata('off');
            },
            error: function (er) {
                alert('Обратитесь к администратору, Ошибка авторизации 3');
                loadingdata('off');
            }
        })
    } else { console.log('Не заполнены все поля!'); }
}