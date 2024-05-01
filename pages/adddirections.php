<?php
if($INFOUSER['rulse'] != 'admin' && $INFOUSER['rulse'] != 'teacher'){
    echo'<div class="section-2 pagination-moth stylesection"><div class="arrowleft"></div><div class="titlemoth">Ошибка доступа к разделу!</div><div class="arrawright"></div></div>';
    die;
}
$admmenu = [['Показать уроки','listlesson'], ['Добавить группу','addgroup'], ['Добавить направление','adddirections']];
?>
<div class="section-1 titlepageHome">
    <div class="titlePage">Добавить направление</div>
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
        <form id="post-noimage" name="add_directions" enctype="multipart/form-data" method="post">
            <input type="hidden" name="operation" value="add_directions">
            <input type="text" name="title_directions" class="default_input" placeholder="Наиминование направления">
            <input type="number" name="num_time" class="default_input" placeholder="Отведенное количество часов">
            <button class="default_btn">Добавить</button>
        </form>
    </div>
</div>