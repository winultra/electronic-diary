<?php
if($INFOUSER['rulse'] != 'admin' && $INFOUSER['rulse'] != 'teacher'){
    echo'<div class="section-2 pagination-moth stylesection"><div class="arrowleft"></div><div class="titlemoth">Ошибка доступа к разделу!</div><div class="arrawright"></div></div>';
    die;
}
$idless = (int)$_GET['idles'];
$admmenu=[];
$admmenu = [['Показать уроки','listlesson'], ['Добавить группу','addgroup'], ['Добавить направление','adddirections']];
$qar = querydb("SELECT psel_lessons.*, psel_directions.title FROM psel_lessons, psel_directions WHERE psel_lessons.id_derections = psel_directions.id_dir",'arrpl');
$qidesc = querydb("SELECT * FROM `psel_directions`",'arrpl');
$qgpart = querydb("SELECT * FROM `psel_grouppart`",'arrpl');
if(!empty($idless) && $idless > 0){
    //Подключение редактирования урока
    include_once('inclide_modules/edit_lessons.php');
}else{
?>
<div class="section-1 titlepageHome">
    <div class="titlePage">Список уроков</div>
    <div class="wrapradiosection">
        <?
            for($i=0; $i < count($admmenu);$i++){
                $aiv='';if($admmenu[$i][1] == $page) $aiv='active';
                echo'<a href="/el/'.$admmenu[$i][1].'"><div class="radiosection1 '.$aiv.'">'.$admmenu[$i][0].'</div></a>';
            }
        ?>
    </div>
</div>
<div class="section-3 homework-user">
    <div class="wpbt">
        <a href="/el/addlesson"><button class="default_btn">Добавить урок</button></a>
    </div>
    <div class="wrapperitemls">
        <span>Направление: </span>
        <select name="subject" class="style_selectForms subject">
            <option value="NULL" disabled selected>Выбрать Направление</option>
            <?for($i=0;$i < count($qidesc);$i++){
                echo'<option onclick="loadInfoListLesson()" value="'.$qidesc[$i]['id_dir'].'">'.$qidesc[$i]['title'].'</option>';
            }?>
        </select>
    </div>
    <div class="wrapperitemls">
        <span>Группа: </span>
        <select name="group" class="style_selectForms group">
            <option value="NULL" disabled selected>Выбрать группу</option>
            <?for($i=0;$i < count($qgpart);$i++){
                echo'<option onclick="loadInfoListLesson()" value="'.$qgpart[$i]['id_gr'].'">'.$qgpart[$i]['title'].'</option>';
            }?>
        </select>
    </div>
    <div class="wrapperbuttomleft" style="height:60px;">
        <button class="default_btn" style="width:auto;padding:5px 15px;float:right;" onclick="loadInfoListLesson()">Выполнить</button>
    </div>
    <div class="wrap-grade-table stylesection" style="border-radius:10px;padding:20px 5px 0;overflow-x:auto;">
        <table class="tablestyle tablestylegrede tableUPlistls">
            <tr><th colspan="4">Выберите нужные фильтры</th></tr>
        </table>
    </div>
</div>
<?}?>