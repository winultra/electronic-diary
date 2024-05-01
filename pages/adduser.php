<?php
if($INFOUSER['rulse'] != 'admin' && $INFOUSER['rulse'] != 'teacher'){
    echo'<div class="section-2 pagination-moth stylesection"><div class="arrowleft"></div><div class="titlemoth">Ошибка доступа к разделу!</div><div class="arrawright"></div></div>';
    die;
}
$qar_group = querydb("SELECT * FROM psel_grouppart",'arrpl');
?>
<div class="section-1 titlepageHome">
    <div class="titlePage">Добавить пользователя</div>
</div>
<div class="section-3 homework-user">
    <div class="wrap-homwork-table stylesection stylesectionInputswp" style="border-radius:10px;padding:30px 25px;">
        <form id="post-noimage" name="add_user" enctype="multipart/form-data" method="post">
            <input type="hidden" name="operation" value="add_user">
            <input type="text" name="login" class="default_input" placeholder="Логин для входа">
            <input type="text" name="email" class="default_input" placeholder="Электроная почта">
            <input type="text" name="name" class="default_input" placeholder="Имя">
            <input type="text" name="familia" class="default_input" placeholder="Фамилия">
            <select name="input_ruls" class="style_selectForms">
                <option value="NULL" disabled selected>Права пользователя</option>
                <option value="1">Преподаватель</option>
                <option value="2">Учащийся</option>
            </select>
            <select name="input_goupWork" class="style_selectForms">
                <option value="NULL" disabled selected>Выберите группу</option>
                <?for($i=0;$i < count($qar_group);$i++){echo'<option value="'.$qar_group[$i]['id_gr'].'">'.$qar_group[$i]['title'].'</option>';}?>
            </select>
            <input type="text" name="pass" class="default_input" placeholder="Пароль пользователя">
            <button class="default_btn">Добавить</button>
        </form>
    </div>
</div>