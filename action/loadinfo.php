<?php
include_once('../../core/linkbd.php');
include_once('../core/lib_function.php');
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'){jsonecho('obradmin');die;}
include_once('../inclide_modules/infouser.php');
$authmetod = chektext('operation');
if($authmetod == 'loaddaylesson'){
    $data = (int)chektext('data');

    if($INFOUSER['rulse'] == 'admin' || $INFOUSER['rulse'] == 'teacher'){
        $kk='yes';
        $qar = querydb("SELECT psel_lessons.*, psel_directions.title FROM psel_lessons, psel_directions WHERE psel_lessons.date = '".$data."' AND psel_lessons.id_derections = psel_directions.id_dir",'arrpl');
    }else{
        $kk='no';
        $qar = querydb("SELECT psel_lessons.*, psel_directions.title FROM psel_lessons, psel_directions WHERE psel_lessons.date = '".$data."' AND psel_lessons.id_group = '".$INFOUSER['id_group']."' AND psel_lessons.id_derections = psel_directions.id_dir",'arrpl');
    }
    $rsarr=[];$nums=0;
    for($i=0; $i < count($qar); $i++){
        if($INFOUSER['rulse'] == 'admin' || $INFOUSER['rulse'] == 'teacher'){
            $rsarr[$i]=array('datetime' => $qar[$i]['time'], 'title'=>$qar[$i]['title_ls'], 'lesson'=>$qar[$i]['title'], 'point'=>$qar[$i]['venue'],'homework'=>$qar[$i]['homework'],'idless'=>$qar[$i]['id_les'],'kek'=>$kk); 
        }else{
            $rsarr[$i]=array('datetime' => $qar[$i]['time'], 'title'=>$qar[$i]['title_ls'], 'lesson'=>$qar[$i]['title'], 'point'=>$qar[$i]['venue'],'homework'=>$qar[$i]['homework'],'kek'=>$kk);
        }
        $nums++;
    }
    if($nums > 0){echo json_encode($rsarr);}
    die;
}
if($authmetod == 'exit'){
    querydb("UPDATE `psel_authhist` SET `condition` = 'off' WHERE `id_user` = '".$INFOUSER['id']."' AND `hash` = '".$passUser."'","update");
    unset($_COOKIE['user_ed']);unset($_COOKIE['pass_ed']);
    setcookie('user_ed', null, -1, '/');setcookie('pass_ed', null, -1, '/');
    jsonecho('sc','sc');die;
}
if($authmetod == 'loaddaylessonWeek'){
    $data = (int)chektext('data');
    $action = chektext('action');
    $deta = chektext('deta');
    $detaarr = explode('-',$deta);

    $nmweek = date('N')-1;
    $todayfirstdayweek = mktime(0, 0, 0, date("m"), date("j")-$nmweek,   date("Y"));
    $todayfirstdayweek = date("Y-n-j", $todayfirstdayweek);
    $arrstodayfirstdayweek = explode('-',$todayfirstdayweek);
    $todaynumberweek=date('N');

    if($action == 'left'){
        $datefirstdayWeekmk = mktime(0, 0, 0, $detaarr[1], $detaarr[2]-7, $detaarr[0]);
        $datefirstdayWeek = date("Y-n-j", $datefirstdayWeekmk);
    }else if($action == 'rigth'){
        $datefirstdayWeekmk = mktime(0, 0, 0, $detaarr[1], $detaarr[2]+7, $detaarr[0]);
        $datefirstdayWeek = date("Y-n-j", $datefirstdayWeekmk);
    }else{die;}
    $yar=date('Y', $datefirstdayWeekmk);
    $today = date('j', $datefirstdayWeekmk);
    $numberweek = date('N', $datefirstdayWeekmk);

    if($action == 'rigth'){ $lastweek = mktime(0, 0, 0, $detaarr[1], $detaarr[2]+13, $detaarr[0]); }
    else if($action == 'left'){ $lastweek = mktime(0, 0, 0, $detaarr[1], $detaarr[2]-1, $detaarr[0]); }
    $lastweek = date("Y-n-j", $lastweek);
    $arrslastweek = explode('-',$lastweek);
    
    $arrsfirstdayweek = explode('-',$datefirstdayWeek);

    $montharr = ['неопределено','Января','Февраля','Марта','Апреля','Мая','Июня','Июля','Августа','Сентября','Откбяря','Ноября','Декабря'];
    $weeksarr = ['неопределено','понедельник','вторник','среда','четверг','пятница','суббота','воскресенье'];
    $weeksarrsk = ['Нп','Пн','Вт','Ср','Чт','Пт','Сб','Вс'];

    if($arrsfirstdayweek[2] > $arrslastweek[2]){ $titleMoth = $arrsfirstdayweek[2].' '.$montharr[$arrsfirstdayweek[1]].' - '.$arrslastweek[2].' '.$montharr[$arrsfirstdayweek[1]+1].' '.$yar; }
    else{ $titleMoth = $arrsfirstdayweek[2].' - '.$arrslastweek[2].' '.$montharr[$arrsfirstdayweek[1]].' '.$yar; }
    
    $answer=[];

    $datetoquery = date('Ynd', $datefirstdayWeekmk);
    $maxDayMoth = cal_days_in_month(CAL_GREGORIAN, $arrsfirstdayweek[1], $yar);
   
    if($INFOUSER['rulse'] == 'admin' || $INFOUSER['rulse'] == 'teacher'){
        $qar = querydb("SELECT psel_lessons.*, psel_directions.title FROM psel_lessons, psel_directions WHERE psel_lessons.date >= '".$datetoquery."' AND psel_lessons.id_derections = psel_directions.id_dir",'arrpl');
    }else{
        $qar = querydb("SELECT psel_lessons.*, psel_directions.title FROM psel_lessons, psel_directions WHERE psel_lessons.date >= '".$datetoquery."' AND psel_lessons.id_group = '".$INFOUSER['id_group']."' AND psel_lessons.id_derections = psel_directions.id_dir",'arrpl');
    }

    $answer['pagination-moth'] = '<div class="arrowleft" onclick="loaddaylessonWeek(\'left\',\''.$datefirstdayWeek.'\');"><i></i></div>
                                  <div class="titlemoth" style="display:none;"><div>'.$titleMoth.'</div></div>
                                  <div class="arrawright" onclick="loaddaylessonWeek(\'rigth\',\''.$datefirstdayWeek.'\');"><i></i></div>';
    $answer['homework-user']='';
    $answer['homework-user'].='<div class="wrpatitlesection">';
    if($todayfirstdayweek == $datefirstdayWeek){
        for($i=1;$i <= 7;$i++){
            $answer['homework-user'].='<div class="divtitlesectionactive">';
            if($todaynumberweek == $i){$answer['homework-user'].='Сегодня';}
            $answer['homework-user'].='</div>';
        }
    }else{ for($i=1;$i <= 7;$i++){$answer['homework-user'] .= '<div class="divtitlesectionactive"></div>';} } 
    
    $answer['homework-user'].='</div><div class="wrapper-weekend">';
    $firsday = $arrsfirstdayweek[2];
    $friday = 1;
    for($i=1;$i <= 7;$i++){
        if($firsday <= $maxDayMoth){
            $dayandmoth = $firsday.' '.$montharr[$arrsfirstdayweek[1]];
            $dayandmothmb = $firsday;
            $sk = $yar.$arrsfirstdayweek[1].$firsday;
        }else{
            $indar = $arrsfirstdayweek[1]+1;
            $dayandmoth = $friday.' '.$montharr[$indar];
            $dayandmothmb = $friday;
            $sk = $yar.$indar.$friday;
            $friday++;
        }
        $addPointClass='';
        if($i==1){$addPointClass = ' activepoint';}
        if($todayfirstdayweek == $datefirstdayWeek){
            if($todaynumberweek == $i){ $answer['homework-user'].='<div class="weekend-day active" onclick="loaddaylesson('.$sk.');">'; }
            else{ $answer['homework-user'].= '<div class="weekend-day'.$addPointClass.'" onclick="loaddaylesson('.$sk.',this);">';}
        }else{
            $answer['homework-user'].='<div class="weekend-day'.$addPointClass.'" onclick="loaddaylesson('.$sk.',this);">';
        }
        $answer['homework-user'].='<div class="wrapper_desktopInfo">';
        $answer['homework-user'].='<div class="numbermoth-day">'.$dayandmoth.'</div>';
        $answer['homework-user'].='<div class="day-week">'.$weeksarr[$i].'</div>';
        $numlessn = 0;
        for($q=0; $q < count($qar);$q++){ if($qar[$q]['date'] == $sk){$numlessn++;} }
        $q--;
        $lasttime = explode('-',$qar[$q]['time']);
        $numlessn = declOfNum($numlessn, array('урок', 'урока', 'уроков'));
        if($numlessn == 0){$answer['homework-user'].='<div class="descriptn">занятия отсутсвуют</div>';}
        else{$answer['homework-user'].='<div class="descriptn">'.$numlessn.' <br> до '.$lasttime[1].'</div>';}
        $answer['homework-user'].='</div>';
        $answer['homework-user'].='<div class="wrapper_mobileInfo">';
        $answer['homework-user'].='<div class="day-week">'.$weeksarrsk[$i].'</div>';
        $answer['homework-user'].='<div class="numbermoth-day">'.$dayandmothmb.'</div>';
        $answer['homework-user'].='</div>';
        $answer['homework-user'].='</div>';
        $firsday++;
    }
    $answer['homework-user'].='</div>
    <div class="wrap-homwork-table stylesection">
        <table class="tablestyle">
            <thead>
                <tr>
                    <th>Время</th>
                    <th>Урок/Направление</th>
                    <th>Место проведение</th>
                    <th>Домашнее задание</th>
                </tr>
            </thead>
            <tbody class="tbodytablehomwork">';
    $firsday = $arrsfirstdayweek[2];
    $sk = $yar.$arrsfirstdayweek[1].$today;
    $nml=0;
    for($i=0;$i < count($qar);$i++){
        if($qar[$i]['date'] == $sk){
            $arrtime = explode('-', $qar[$i]['time']);
            $answer['homework-user'].='<tr>';
                $answer['homework-user'].='<th>'.$arrtime[0].' - '.$arrtime[1].'</th>';
                $answer['homework-user'].='<th>'.$qar[$i]['title_ls'].' / '.$qar[$i]['title'].'</th>';
                $answer['homework-user'].='<th>'.$qar[$i]['venue'].'</th>';
                $answer['homework-user'].='<th>'.$qar[$i]['homework'].'</th>';
            $answer['homework-user'].='</tr>';
            $nml++;
        }
    }
    if($nml == 0){$answer['homework-user'].='<tr><th colspan="4">Занятия отсутсвуют</th></tr>';}
    $answer['homework-user'].='</tbody></table>';
    for($i=0;$i < count($qar);$i++){
        if($qar[$i]['date'] == $sk){
            $arrtime = explode('-', $qar[$i]['time']);
            $answer['homework-user'].='<div class="wrappeMobileInterface"><div class="wraplesson">';
                $answer['homework-user'].='<div class="titleLesson">'.$qar[$i]['title'].'</div>';
                $answer['homework-user'].='<div class="titleLesson_tema">'.$qar[$i]['title_ls'].'</div>';
                $answer['homework-user'].='<div class="timelesson">'.$arrtime[0].' - '.$arrtime[1].'</div>';
                $answer['homework-user'].='<div class="homeworkLesson">'.$qar[$i]['homework'].'</div>';
            $answer['homework-user'].='</div></div>';
            $nml++;
        }
    }
    if($nml == 0){$answer['homework-user'].='<div class="wrappeMobileInterface"><div class="wraplesson" style="text-align:center;">Занятия отсутсвуют</div></div>';}
    $answer['homework-user'].='</div></div>';

    echo json_encode($answer);
}
if($authmetod == 'saveEditHw'){
    if($INFOUSER['rulse'] != 'admin' && $INFOUSER['rulse'] != 'teacher'){jsonecho('errorAccess');die;}
    $edithm=chektext('inputvalhw');
    $idless=(int)chektext('idles');
    querydb("UPDATE `psel_lessons` SET `homework`='".$edithm."' WHERE `id_les` = '".$idless."'",'UPD');
    jsonecho('sc','sc');die;
}
if($authmetod == 'loadInfoteacherlog'){
    if($INFOUSER['rulse'] != 'admin' && $INFOUSER['rulse'] != 'teacher'){jsonecho('errorAccess');die;}
    $data_subject=(int)chektext('data_subject');
    $data_group=(int)chektext('data_group');
    $nmmoth = (int)chektext('data_loadMoth');$nmyar = (int)chektext('data_loadYar');$numdaymoth = date('t');
    $arrmoth = ['Ошибка','Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'];
    $yararr = [2022,2023,2024,2025,2026];
    $qstudent = querydb("SELECT * FROM `psel_users` WHERE `rulse` = 'student' AND `id_group` = '".$data_group."' ORDER BY familia",'arrpl');
    $qgrade = querydb("SELECT * FROM `psel_grade` WHERE `id_direc` = '".$data_subject."' AND `date_point` LIKE '".$nmyar.$nmmoth."%'","arrpl");
    $qabsence = querydb("SELECT * FROM `psel_absence` WHERE `id_direc` = '".$data_subject."' AND `date` LIKE '".$nmyar.$nmmoth."%'","arrpl");
    $qarlessons = querydb("SELECT * FROM `psel_lessons` WHERE `id_derections` = '".$data_subject."' AND `date` LIKE '".$nmyar.$nmmoth."%'","arrpl");
    echo'<thead class="moth_day">';
            echo'<tr>';
                echo'<th>Ученики</th>';
                    
                    for($i=1;$i <= $numdaymoth;$i++){
                        $signl=0;
                        for($qq=0;$qq < count($qarlessons);$qq++){
                            $SHday = $nmyar.$nmmoth.$i;
                            if($nmyar.$nmmoth.$i == $qarlessons[$qq]['date']){
                                $signl=1;
                                echo'<th class="activeTHlesson" title="'.$qarlessons[$qq]['title_ls'].'"><a target="_blank" href="/el/listlesson?idles='.$qarlessons[$qq]['id_les'].'">'.$i.'</a></th>';
                            }
                        }
                        if($signl == 0){echo'<th>'.$i.'</th>';}
                    }
                echo'</tr>';
            echo'</thead>';
            echo'<tbody>';
                for($i=0;$i < count($qstudent);$i++){
                    echo'<tr>';
                        echo'<th>'.$qstudent[$i]['familia'].' '.$qstudent[$i]['name'].'</th>';
                        for($q=1; $q <= $numdaymoth;$q++){
                            echo'<th id="day_'.$q.'_'.$qstudent[$i]['id'].'" onclick="intogradeusers(\''.$q.'\',\''.$nmmoth.'\',\''.$qstudent[$i]['id'].'\',this)">';
                            $sdyn=$nmyar.$nmmoth.$q;
                            for($qq=0;$qq < count($qgrade);$qq++){
                                if($qstudent[$i]['id'] == $qgrade[$qq]['id_user']){
                                    if($sdyn == $qgrade[$qq]['date_point']){
                                        echo $qgrade[$qq]['grade'];
                                    }
                                }
                            }
                            for($qa=0;$qa < count($qabsence);$qa++){
                                if($qstudent[$i]['id'] == $qabsence[$qa]['id_users']){
                                    if($sdyn == $qabsence[$qa]['date']){
                                        echo'Н';
                                    }
                                }
                            }
                            echo'</th>';
                        }
                    echo'<tr>';
                }
            echo'</tbody>';
}
if($authmetod == 'savegradeuser'){
    if($INFOUSER['rulse'] != 'admin' && $INFOUSER['rulse'] != 'teacher'){jsonecho('errorAccess');die;}
    $day=(int)chektext('data_loadMoth');
    $month=(int)chektext('month');
    $yar = (int)chektext('dt_yar');
    $vl = chektext('vl');
    $idst = (int)chektext('idst');
    $data_subject=(int)chektext('data_subject');
    $date_echer = $yar.$month.$day;
    $sk=querydb("SELECT * FROM `psel_lessons` WHERE `date` = '".$date_echer."'",'arrpl');
    if(empty($sk)){jsonecho('erNolesson');die;}
    if(!empty($vl) || $vl == '0'){
        $vl = mb_strtoupper($vl);
        if($vl == 'Н'){
            $chk = querydb("SELECT * FROM `psel_absence` WHERE `id_users` = '".$idst."' AND `id_lesson` = '".$sk[0]['id_les']."' AND `date` = '".$date_echer."' AND `id_direc` = '".$data_subject."' LIMIT 1",'arrpl');
            if(empty($chk)){
                querydb("INSERT INTO `psel_absence`(`id_users`, `id_direc`, `id_lesson`, `id_teacher`, `date`) VALUES ('".$idst."','".$data_subject."','".$sk[0]['id_les']."','".$INFOUSER['id']."','".$date_echer."')",'INST');
            }else{jsonecho('erNYes');die;}
            jsonecho('sc','sc');die;
        }
        else if($vl > 0 && $vl < 11){
            $chk = querydb("SELECT * FROM `psel_grade` WHERE `id_user` = '".$idst."' AND `id_less` = '".$sk[0]['id_les']."' AND `date_point` = '".$date_echer."' LIMIT 1",'arrpl');
            $vl = (int)$vl;
            if(empty($chk)){
                querydb("INSERT INTO `psel_grade`(`id_user`, `id_direc`, `id_less`, `date_point`, `grade`, `id_teacher`) VALUES ('".$idst."','".$data_subject."','".$sk[0]['id_les']."','".$date_echer."','".$vl."','".$INFOUSER['id']."')",'INST');
            }else{
                querydb("UPDATE `psel_grade` SET `grade` = '".$vl."' WHERE `id_user` = '".$idst."' AND `id_less` = '".$sk[0]['id_les']."' AND `date_point` = '".$date_echer."'","update");
            }
            jsonecho('sc','sc');die;
        }else if($vl == '0'){//удалить оценку или Н
            querydb("DELETE FROM `psel_grade` WHERE `id_user` = '".$idst."' AND `id_less` = '".$sk[0]['id_les']."' AND `date_point` = '".$date_echer."'",'DEL');
            querydb("DELETE FROM `psel_absence` WHERE `id_users` = '".$idst."' AND `id_lesson` = '".$sk[0]['id_les']."' AND `date` = '".$date_echer."' AND `id_direc` = '".$data_subject."'",'DEL');
            jsonecho('sc','sc');die;
        }else{jsonecho('NoValid');die;}
    }
}
if($authmetod == 'loadInfoListLesson'){
    if($INFOUSER['rulse'] != 'admin' && $INFOUSER['rulse'] != 'teacher'){jsonecho('errorAccess');die;}
    $data_subject=(int)chektext('data_subject');
    $data_group=(int)chektext('data_group');
    $sk=querydb("SELECT * FROM `psel_lessons` WHERE `id_derections` = '".$data_subject."' AND `id_group` = '".$data_group."' ORDER BY id_les DESC",'arrpl');
    echo'<thead class="moth_day">';
        echo'<tr>';
            echo'<th>Дата / время</th>';
            echo'<th>Тема занятия</th>';
            echo'<th>Место проведения</th>';
            echo'<th>Домашняя работа</th>';
            echo'<th>Действия</th>';
        echo'</tr>';
    echo'</thead>';
    echo'<tbody>';
    for($i=0; $i < count($sk);$i++){
        $timear = explode('-',$sk[$i]['time']);
        $datetimeAr = dateforamtirs($sk[$i]['date'],$timear[0],'ar');
        print_r($datetimeAr);
        $date_time = $datetimeAr['day'].".".$datetimeAr['moth'].".".$datetimeAr['yar'].'&nbsp / &nbsp'.$datetimeAr['hours'].':'.$datetimeAr['min'].' - '.$timear[1];
        echo'<tr>';
            echo'<th>'.$date_time.'</th>';
            echo'<th>'.$sk[$i]['title_ls'].'</th>';
            echo'<th>'.$sk[$i]['venue'].'</th>';
            echo'<th>'.$sk[$i]['homework'].'</th>';
            echo'<th><a class="url_btn_table" href="/el/listlesson?idles='.$sk[$i]['id_les'].'">Редактировать</a></th>';
        echo'</tr>';
    }
    echo'</tbody>';
}
if($authmetod == 'delete_lesson'){
    if($INFOUSER['rulse'] != 'admin' && $INFOUSER['rulse'] != 'teacher'){jsonecho('errorAccess');die;}
    $ar_request = explode('idles=',$_SERVER['HTTP_REFERER']);
    $idLess = (int)$ar_request[1];
    if($idLess > 0){
        querydb("DELETE FROM `psel_lessons` WHERE `id_les` = '".$idLess."'",'DEL');
        jsonecho('sc','sc');die;
    }else{jsonecho('errorID');die;}
}
if($authmetod == 'load_group_rating'){
    if($INFOUSER['rulse'] != 'admin' && $INFOUSER['rulse'] != 'teacher'){jsonecho('errorAccess');die;}
    $data_group=(int)chektext('data_group');
    $slUsers = querydb("SELECT id,name,familia,id_group FROM `psel_users` WHERE `id_group` = '".$data_group."'",'arrpl');
    $ratingAr=[];
    $slGrade = querydb("SELECT *  FROM `psel_grade`",'arrpl');
    for($iu=0; $iu < count($slUsers);$iu++){
        $bals=0;$retunrsar=[];
        for($ig=0; $ig < count($slGrade);$ig++){
            if($slGrade[$ig]['id_user'] == $slUsers[$iu]['id']){
                $bals+=(int)$slGrade[$ig]['grade'];
            }
        }
        $retunrsar=["id"=>$slUsers[$iu]['id'],'fio'=>$slUsers[$iu]['familia'].' '.$slUsers[$iu]['name'],'bals'=>$bals];
        $ratingAr[] = $retunrsar;
        }
        usort($ratingAr, function($a,$b){ return $a['bals'] < $b['bals']; });
        $nb=1;
        for($ir=0;$ir<count($ratingAr);$ir++){
            $atUser = '';
            if($ratingAr[$ir]['id'] == $INFOUSER['id']) $atUser = "class='active'";
            echo"<tr ".$atUser.">";
                echo"<th>".$nb."</th>";
                echo"<th>".$ratingAr[$ir]['fio']."</th>";
                echo"<th>".$ratingAr[$ir]['bals']."</th>";
            echo"</tr>";
            $nb++;
        }
}
?>