<?php
$LoginUser = chektextST($_COOKIE['user_ed']);
$passUser = chektextST($_COOKIE['pass_ed']);
if(!empty($LoginUser) && !empty($passUser)){
$INFOUSER = querydb("SELECT * FROM psel_users, psel_authhist WHERE psel_users.login = '".$LoginUser."' AND psel_authhist.hash = '".$passUser."' AND psel_users.id = psel_authhist.id_user AND psel_authhist.condition = 'on'");
}else{$INFOUSER = null;}
if(empty($INFOUSER['id'])){
    unset($_COOKIE['user_ed']);unset($_COOKIE['pass_ed']);
    setcookie('user_ed', null, -1, '/');setcookie('pass_ed', null, -1, '/');
    $LoginUser = chektextST($_COOKIE['user_ed']);
    $passUser = chektextST($_COOKIE['pass_ed']);
}
?>