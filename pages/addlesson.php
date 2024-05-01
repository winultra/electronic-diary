<?php
if($INFOUSER['rulse'] != 'admin' && $INFOUSER['rulse'] != 'teacher'){
    echo'<div class="section-2 pagination-moth stylesection"><div class="arrowleft"></div><div class="titlemoth">Ошибка доступа к разделу!</div><div class="arrawright"></div></div>';
    die;
}
$qar_derection = querydb("SELECT * FROM psel_directions",'arrpl');
$qar_group = querydb("SELECT * FROM psel_grouppart",'arrpl');
$admmenu = [['Показать уроки','listlesson'], ['Добавить группу','addgroup'], ['Добавить направление','adddirections']];
?>
<div class="section-1 titlepageHome">
    <div class="titlePage">Добавить урок</div>
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
    <div class="wrap-homwork-table stylesection stylesectionInputswp" style="border-radius:10px;padding:30px 25px;">
        <form id="post-noimage" name="add_lesson" enctype="multipart/form-data" method="post">
            <input type="hidden" name="operation" value="add_lesson">
            <div class="titileform">Дата и время начала занятия</div>
            <input type="datetime-local" name="date_time" class="default_input" placeholder="Дата проведения">
            <div class="titileform">Время окончания занятия</div>
            <input type="time" name="time_end" class="default_input" placeholder="Время окончания">
            <select name="input_napravleni" class="style_selectForms">
                <option value="NULL" disabled selected>Выберите направление</option>
                <?for($i=0;$i < count($qar_derection);$i++){echo'<option value="'.$qar_derection[$i]['id_dir'].'">'.$qar_derection[$i]['title'].'</option>';}?>
            </select>
            <input type="text" name="title" class="default_input" placeholder="Тема занятия">
            <input type="text" name="venue" class="default_input" placeholder="Место проведения">
            <input type="text" name="home_work" class="default_input" placeholder="Домашине задание (Если есть)">
            <select name="input_goupWork" class="style_selectForms">
                <option value="NULL" disabled selected>Выберите группу</option>
                <?for($i=0;$i < count($qar_group);$i++){echo'<option value="'.$qar_group[$i]['id_gr'].'">'.$qar_group[$i]['title'].'</option>';}?>
            </select>
            <button class="default_btn">Добавить</button>
        </form>
    </div>
</div>