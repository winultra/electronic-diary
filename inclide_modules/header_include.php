<?
$sim = mb_substr($INFOUSER['name'],0,1);
$kalAct='';$grAct='';$achAct='';
if($page == 'home') $kalAct='active';
if($page == 'grade') $grAct='active';
if($page == 'achievements') $achAct='active';
$imageprofile = $INFOUSER['img'];
if(empty($INFOUSER['img'])){
    $imageprofile = '<div class="imageProfile">'.$sim.'</div>';
}else{
    $linkputs = '/el/img_users/';
    $imageprofile = '<div class="imageProfileIm"><img src="'.$linkputs.$INFOUSER['img'].'"></div>';
}
if($INFOUSER['rulse'] == 'admin' || $INFOUSER['rulse'] == 'teacher'){
    $data_profile=[['Мои данные','profile'],['Добавить пользователя','adduser'],['Выход','','onclick="exituser();return false;"']];
    $clad='admin';
}else{
    $data_profile=[['Мои данные','profile'],['Выход','','onclick="exituser();"']];
    $clad='';
}
?>
<header class="topbar">
    <div class="logotype"><span>Дневник<span></div>
    <nav>
        <ul>
            <a href="/el/"><li class="<?=$kalAct?>">Расписание</li></a>
            <a href="/el/grade"><li class="<?=$grAct?>">Успеваемость</li></a>
            <a href="/el/achievements"><li class="<?=$achAct?>">Достижения</li></a>
        </ul>
    </nav>
    <div class="profile">
        <?=$imageprofile?>
        <div class="nameProfil"><?=$INFOUSER['name']?></div>
        <div class="wrapToglArrow">
            <div class="arProfile">
                <span class="arProfile-left"></span>
                <span class="arProfile-right"></span>
            </div>
        </div>
        <div class="wrapmenuprofile">
            <ul>
                <?
                    for($i=0;$i < count($data_profile);$i++){
                        if(count($data_profile[$i]) > 2) echo'<a href='.$data_profile[$i][1].'><li '.$data_profile[$i][2].'>'.$data_profile[$i][0].'</li></a>';
                        else echo'<a href="'.$data_profile[$i][1].'"><li>'.$data_profile[$i][0].'</li></a>';                    
                    }
                ?>
            </ul>
        </div>
    </div>
</header>
<nav class="navigationMobile">
    <a href="/el/">
        <div class="itmesMunu <?=$kalAct?>">
            <i class="icon"></i>
            <div class="titileMenu">Расписание</div>
        </div>
    </a>
    <a href="/el/grade">
        <div class="itmesMunu <?=$grAct?>">
            <i class="icon grade"></i>
            <div class="titileMenu">Успеваемость</div>
        </div>
    </a>
    <a href="/el/achievements">
        <div class="itmesMunu <?=$achAct?>">
            <i class="icon achiv"></i>
            <div class="titileMenu">Достижения</div>
        </div>
    </a>
    <a href="#" onclick="$('.wrapmenuMobile').toggleClass('active');$('.im_more').toggleClass('active');return false;">
        <div class="itmesMunu im_more">
            <i class="icon more"></i>
            <div class="titileMenu">Ещё</div>
        </div>
    </a>
    <div class="wrapmenuMobile <?=$clad?>">
        <ul>
        <?
            for($i=0;$i < count($data_profile);$i++){
                if(count($data_profile[$i]) > 2) echo'<a href='.$data_profile[$i][1].'><li '.$data_profile[$i][2].'>'.$data_profile[$i][0].'</li></a>';
                else echo'<a href="'.$data_profile[$i][1].'"><li>'.$data_profile[$i][0].'</li></a>';                    
            }
                ?>
        </ul>
    </div>
</nav>