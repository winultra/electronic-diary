<?php
if($INFOUSER['rulse'] != 'admin' && $INFOUSER['rulse'] != 'teacher'){
    echo'<div class="section-2 pagination-moth stylesection"><div class="arrowleft"></div><div class="titlemoth">Ошибка доступа к разделу!</div><div class="arrawright"></div></div>';
    die;
}
$q_infoless = querydb("SELECT * FROM psel_lessons WHERE `id_les` = '".$idless."' LIMIT 1");
if(empty($q_infoless)) {
    echo'<div class="section-2 pagination-moth stylesection"><div class="arrowleft"></div><div class="titlemoth">Урок отсутвсует!<br> <a href="/el/listlesson">Вернуться</a></div><div class="arrawright"></div></div>';
    die;
}
$qar_derection = querydb("SELECT * FROM psel_directions",'arrpl');
$qar_group = querydb("SELECT * FROM psel_grouppart",'arrpl');
$dateLess = $q_infoless['date'];
$lessTimeBd = explode('-', $q_infoless['time']);
?>
<div class="section-1 titlepageHome">
    <div class="titlePage">Редактировать урок</div>
</div>
<div class="section-3 homework-user">
    <div class="wrap-homwork-table stylesection stylesectionInputswp" style="border-radius:10px;padding:30px 25px;">
        <form id="post-noimage" name="edit_lesson" enctype="multipart/form-data" method="post">
            <input type="hidden" name="operation" value="edit_lesson">
            <div class="titileform">Дата и время начала занятия</div>
            <input type="datetime-local" name="date_time" class="default_input" value="<?=dateforamtirs($q_infoless['date'],$lessTimeBd[0],'-')?>" placeholder="Дата проведения">
            <div class="titileform">Время окончания занятия</div>
            <input type="time" name="time_end" value="<?=$lessTimeBd[1]?>" class="default_input" placeholder="Время окончания">
            <select name="input_napravleni" class="style_selectForms">
                <?for($i=0;$i < count($qar_derection);$i++){
                    $sl='';
                    if($qar_derection[$i]['id_dir'] == $q_infoless['id_derections']) $sl='selected';
                    echo'<option value="'.$qar_derection[$i]['id_dir'].'" '.$sl.'>'.$qar_derection[$i]['title'].'</option>';
                }?>
            </select>
            <input type="text" name="title" value="<?=$q_infoless['title_ls']?>" class="default_input" placeholder="Тема занятия">
            <input type="text" value="<?=$q_infoless['venue']?>" name="venue" class="default_input" placeholder="Место проведения">
            <input type="text" value="<?=$q_infoless['homework']?>" name="home_work" class="default_input" placeholder="Домашине задание (Если есть)">
            <select name="input_goupWork" class="style_selectForms">
                <?for($i=0;$i < count($qar_group);$i++){
                    $sl='';
                    if($qar_group[$i]['id_gr'] == $q_infoless['id_group']) $sl='selected';
                    echo'<option value="'.$qar_group[$i]['id_gr'].'" '.$sl.'>'.$qar_group[$i]['title'].'</option>';
                }?>
            </select>
            <button class="default_btn">Сохранить</button>
        </form>
        <button class="default_btn" onclick="delete_lesson()" style="margin-top:15px;background-color: red;">Удалить урок</button>
    </div>
</div>