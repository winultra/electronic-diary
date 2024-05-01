<div class="section-1 titlepageHome">
    <div class="titlePage">Мой профиль</div>
</div>
<div class="section-2 pagination-moth stylesection" style="padding: 0 20px;">
    <div class="wrapperingputsProfile">
        <div class="wrapperinputs">
            <div class="tileinput">Имя</div>
            <input type="text" name="profile_name" class="default_input" value="<?=$INFOUSER['name']?>">
        </div>
        <div class="wrapperinputs">
            <div class="tileinput">Фамилия</div>
            <input type="text" name="profile_familia" class="default_input" value="<?=$INFOUSER['familia']?>">
        </div>
        <div class="wrapperinputs">
            <div class="tileinput">E-Mail</div>
            <form id="post-noimage" name="chang_email" enctype="multipart/form-data" method="post">
                <input type="text" name="profile_email" class="default_input" value="<?=$INFOUSER['email']?>">
                <input type="hidden" name="operation" value="chang_email">
                <button class="default_btn" style="margin:15px 0;">Изменить e-mail</button>
            </form>
        </div>
    </div>
</div>
<div class="section-1 titlepageHome">
    <div class="titlePage">Изменить пароль</div>
</div>
<div class="section-2 pagination-moth stylesection">
    <div class="wrapperingputsProfile">
        <form id="post-noimage" name="chang_pass" enctype="multipart/form-data" method="post">
            <div class="wrapperinputs">
                <div class="tileinput">Старый пароль</div>
                <input type="password" name="old_pass" class="default_input">
            </div>
            <div class="wrapperinputs">
                <div class="tileinput">Новый пароль</div>
                <input type="password" name="new_pass" class="default_input">
            </div>
            <div class="wrapperinputs">
                <input type="hidden" name="operation" value="chang_pass">
                <div class="tileinput">Повторить новый пароль</div>
                <input type="password" name="repeat_new_pass" class="default_input">
            </div>
            <button class="default_btn" style="margin-bottom:15px;">Изменить</button>
        </form>
    </div>
</div>