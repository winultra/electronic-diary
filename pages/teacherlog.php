<?php
if($INFOUSER['rulse'] != 'admin' && $INFOUSER['rulse'] != 'teacher'){
    echo'<div class="section-2 pagination-moth stylesection"><div class="arrowleft"></div><div class="titlemoth">Ошибка доступа к разделу!</div><div class="arrawright"></div></div>';
    die;
}
$nmmoth = date('n');$nmyar = date('Y');$numdaymoth = date('t');
$arrmoth = ['Ошибка','Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'];
$yararr = [2022,2023,2024,2025,2026];
$qidesc = querydb("SELECT * FROM `psel_directions`",'arrpl');
$qgpart = querydb("SELECT * FROM `psel_grouppart`",'arrpl');
?>
<div class="section-1 titlepageHome">
    <div class="titlePage">Учительский журнал</div>
</div>
<div class="section-1 titlepageHome" style="height:auto;">
    <div class="wrapperitemlsdate">
        <select name="loadMoth" class="style_selectForms loadMoth">
            <?for($i=1;$i < count($arrmoth);$i++){
                if($i == $nmmoth) echo'<option onclick="loadInfoteacherlog()" value="'.$i.'" selected>'.$arrmoth[$i].'</option>';
                else echo'<option onclick="loadInfoteacherlog()" value="'.$i.'">'.$arrmoth[$i].'</option>';
            }?>
        </select>
        <select name="loadYar" class="style_selectForms loadYar">
            <?for($i=0;$i < count($yararr);$i++){
                if($yararr[$i] == $nmyar) echo'<option onclick="loadInfoteacherlog()" value="'.$yararr[$i].'" selected>'.$yararr[$i].'</option>';
                else echo'<option onclick="loadInfoteacherlog()" value="'.$yararr[$i].'">'.$yararr[$i].'</option>';
            }?>
        </select>
    </div>
    <div class="wrapperitemls">
        <span>Направление: </span>
        <select name="subject" class="style_selectForms subject">
            <option value="NULL" disabled selected>Выбрать Направление</option>
            <?for($i=0;$i < count($qidesc);$i++){
                echo'<option onclick="loadInfoteacherlog()" value="'.$qidesc[$i]['id_dir'].'">'.$qidesc[$i]['title'].'</option>';
            }?>
        </select>
    </div>
    <div class="wrapperitemls">
        <span>Группа: </span>
        <select name="group" class="style_selectForms group">
            <option value="NULL" disabled selected>Выбрать группу</option>
            <?for($i=0;$i < count($qgpart);$i++){
                echo'<option onclick="loadInfoteacherlog()" value="'.$qgpart[$i]['id_gr'].'">'.$qgpart[$i]['title'].'</option>';
            }?>
        </select>
    </div>
    <div class="wrapperbuttomleft" style="height:60px;">
        <button class="default_btn" style="width:auto;padding:5px 15px;float:right;" onclick="loadInfoteacherlog()">Выполнить</button>
    </div>
</div>
<div class="section-3 homework-user">
    <div class="wrap-homwork-table stylesection" style="border-radius:10px;padding:20px 5px 0;overflow-x:auto;">
        <table class="tablestyle tablestylegrede tablestyleteachelog">
            <tr><th colspan="4">Выберите нужные фильтры</th></tr>
        </table>
    </div>
</div>