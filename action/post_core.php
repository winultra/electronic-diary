<?php
include_once('../../core/linkbd.php');
include_once('../core/lib_function.php');
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){jsonecho('obradmin');die;}
include_once('../inclide_modules/infouser.php');
$authmetod = chektext('operation');
if($authmetod == 'auth_user'){
    $login = chektext('emailorlogin');
    $pass = chektext('password');
    if(!empty($login) && !empty($pass) && empty($LoginUser) && empty($passUser)){
        $sol1="aGxzcer!";$sol2="ladkflsdf";
        $respass = md5(md5($sol1.$pass.$sol2));
        if(preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $login)){
            $qr = querydb("SELECT id,password,login FROM `psel_users` WHERE `email` = '".$login."'");
        }else{
            $qr = querydb("SELECT id,password,login FROM `psel_users` WHERE `login` = '".$login."'");
        }
        if($respass == $qr['password']){
            $hashKod = generateCode(10).time();
            $hash = hash('sha256', $hashKod);
            querydb("INSERT INTO `psel_authhist` (`id_user`, `data_time`, `ip_adres`, `hash`) VALUES ('".$qr['id']."','".date("F j, Y, g:i a")."','".$_SERVER['HTTP_CLIENT_IP']."','".$hash."')",'ins');
            setcookie("user_ed", $qr['login'], time() + 60*60*24*365,"/");
            setcookie("pass_ed", $hash , time() + 60*60*24*365,"/");
            jsonecho('sc','sc');die;
        }else{jsonecho('nologinpass');die;}
    }else{jsonecho('obradmin');die;}
}
if($authmetod == 'add_lesson'){
    if($INFOUSER['rulse'] != 'admin' && $INFOUSER['rulse'] != 'teacher'){jsonecho('errorAcces');die;}
    $date_timeArr=explode('T', chektext('date_time'));
    $dateAr=explode('-',$date_timeArr[0]);
    $date_post = (int)$dateAr[0].(int)$dateAr[1].(int)$dateAr[2];
    $time_end = chektext('time_end');
    $time_post = $date_timeArr[1].'-'.$time_end;
    $napr = (int)chektext('input_napravleni');
    $venue = chektext('venue');
    $home_work = chektext('home_work');
    $titlels = chektext('title');
    $goupWork = (int)chektext('input_goupWork');
    querydb("INSERT INTO `psel_lessons` (`date`, `time`, `title_ls`, `id_derections`, `venue`, `homework`, `id_group`) VALUES ('".$date_post."','$time_post','".$titlels."','".$napr."','".$venue."','".$home_work."','".$goupWork."')",'ins'); 
    jsonecho('sc','sc');die;
}
if($authmetod == 'add_group'){
    if($INFOUSER['rulse'] != 'admin' && $INFOUSER['rulse'] != 'teacher'){jsonecho('errorAcces');die;}
    $title_group = chektext('title_group');
    querydb("INSERT INTO `psel_grouppart` (`title`) VALUES ('".$title_group."')",'ins');
    jsonecho('sc','sc');die;
}
if($authmetod == 'add_directions'){
    if($INFOUSER['rulse'] != 'admin' && $INFOUSER['rulse'] != 'teacher'){jsonecho('errorAcces');die;}
    $title_group = chektext('title_directions');
    $num_time = chektext('num_time');
    querydb("INSERT INTO `psel_directions` (`title`,`num_lesson`) VALUES ('".$title_group."','".$num_time."')",'ins');
    jsonecho('sc','sc');die;
}
if($authmetod == 'add_user'){
    if($INFOUSER['rulse'] != 'admin' && $INFOUSER['rulse'] != 'teacher'){jsonecho('errorAcces');die;}
    $login=chektext('login');
    $email=chektext('email');
    $name=chektext('name');
    $fam=chektext('familia');
    $rulsUser=(int)chektext('input_ruls');
    $idgroup=(int)chektext('input_goupWork');
    $pass=chektext('pass');
    if(empty($login)){ jsonecho('er_nologin');die; }
    if(empty($email)){ jsonecho('er_noemail');die; }
    if(empty($name)){ jsonecho('er_noname');die; }
    if(empty($fam)){ jsonecho('er_nofam');die; }
    if(empty($pass)){ jsonecho('er_nopass');die; }
    $searchactiveuser = querydb("SELECT * FROM `psel_users` WHERE `login` = '".$login."' OR `email` = '".$email."'");
    $sol1="aGxzcer!";$sol2="ladkflsdf";
    $respass = md5(md5($sol1.$pass.$sol2));
    if($searchactiveuser > 0){jsonecho('er_useractive_'.$respass);die;}
    if($rulsUser == '1') $rulsUser = 'teacher';
    else $rulsUser = 'student';
    querydb("INSERT INTO `psel_users`(`login`, `email`, `password`, `name`, `familia`, `img`, `rulse`, `id_group`) VALUES ('".$login."','".$email."','".$respass."','".$name."','".$fam."','','".$rulsUser."','".$idgroup."')",'ins');
    jsonecho('sc','sc');die;
}
if($authmetod == 'chang_pass'){
    if(empty($INFOUSER['id'])){jsonecho('errorAcces');die;}
    $oldP=chektext('old_pass');
    $newP=chektext('new_pass');
    $repeatNP=chektext('repeat_new_pass');
    if(empty($oldP) || empty($newP) || empty($repeatNP)){jsonecho('ernodata');die;}
    if($newP != $repeatNP){jsonecho('ernopasrepass');die;}
    $sol1="aGxzcer!";$sol2="ladkflsdf";
    $oldpss = md5(md5($sol1.$oldP.$sol2));
    if($INFOUSER['password'] != $oldpss){jsonecho('ernooldpass');die;}
    $newPass = md5(md5($sol1.$newP.$sol2));
    querydb("UPDATE `psel_users` SET `password` = '".$newPass."' WHERE `id` = '".$INFOUSER['id']."' AND `login` = '".$INFOUSER['login']."' AND `password` = '".$oldpss."'","update");
    jsonecho('sc','sc');die;
}
if($authmetod == 'chang_email'){
    if(empty($INFOUSER['id'])){jsonecho('errorAcces');die;}
    $emailChange=chektext('profile_email');
    if($INFOUSER['email'] == $emailChange){jsonecho('sc','sc');die;}
    if(preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $emailChange)){
        querydb("UPDATE `psel_users` SET `email` = '".$emailChange."' WHERE `id` = '".$INFOUSER['id']."' AND `login` = '".$INFOUSER['login']."'","update");
        jsonecho('sc','sc');die;
    }else{jsonecho('errorNovalidEmail');die;}
}
if($authmetod == 'edit_lesson'){
    if($INFOUSER['rulse'] != 'admin' && $INFOUSER['rulse'] != 'teacher'){jsonecho('errorAcces');die;}
    $ar_request = explode('idles=',$_SERVER['HTTP_REFERER']);
    $idLess = (int)$ar_request[1];
    $date_timeArr=explode('T', chektext('date_time'));
    $dateAr=explode('-',$date_timeArr[0]);
    $date_post = (int)$dateAr[0].(int)$dateAr[1].(int)$dateAr[2];
    $time_end = chektext('time_end');
    $time_post = $date_timeArr[1].'-'.$time_end;
    $napr = (int)chektext('input_napravleni');
    $venue = chektext('venue');
    $home_work = chektext('home_work');
    $titlels = chektext('title');
    $goupWork = (int)chektext('input_goupWork');
    querydb("UPDATE `psel_lessons` SET `date` = '".$date_post."', `time` = '".$time_post."', `title_ls` = '".$titlels."', `id_derections` = '".$napr."', `venue` = '".$venue."', `homework` = '".$home_work."', `id_group` = '".$goupWork."' WHERE `id_les` = '".$idLess."'","update");
    jsonecho('sc','sc');die;
}
?>