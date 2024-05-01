<?php
$yar=date('Y');
$today = date('j');
$numberweek = date('N');
if($numberweek == 1)$nwks=6;
if($numberweek == 2)$nwks=5;
if($numberweek == 3)$nwks=4;
if($numberweek == 4)$nwks=3;
if($numberweek == 5)$nwks=2;
if($numberweek == 6)$nwks=1;
if($numberweek == 7)$nwks=0;
$lastweek = mktime(0, 0, 0, date("m"), date("j")+$nwks, date("Y"));
$lastweek = date("Y-n-j", $lastweek);
$arrslastweek = explode('-',$lastweek);

$nmweek = date('N')-1;
$firstdayweek = mktime(0, 0, 0, date("m"), date("j")-$nmweek, date("Y"));
$firstdayweek = date("Y-n-j", $firstdayweek);
$arrsfirstdayweek = explode('-',$firstdayweek);

$montharr = ['неопределено','Января','Февраля','Марта','Апреля','Мая','Июня','Июля','Августа','Сентября','Откбяря','Ноября','Декабря'];
$weeksarr = ['неопределено','понедельник','вторник','среда','четверг','пятница','суббота','воскресенье'];
$weeksarrsk = ['Нп','Пн','Вт','Ср','Чт','Пт','Сб','Вс'];

if($arrsfirstdayweek[2] > $arrslastweek[2]){ $titleMoth = $arrsfirstdayweek[2].' '.$montharr[date('n')].' - '.$arrslastweek[2].' '.$montharr[date('n')+1].' '.$yar; }
else{ $titleMoth = $arrsfirstdayweek[2].' - '.$arrslastweek[2].' '.$montharr[date('n')].' '.$yar; }

$datetoquery = date('Ynd');
$datafirstdayweek = date("Ynd", $firstdayweek);

$maxDayMoth = cal_days_in_month(CAL_GREGORIAN, $arrsfirstdayweek[1], $yar);
$icoedit='';

$admmenu=[];
if($INFOUSER['rulse'] == 'admin' || $INFOUSER['rulse'] == 'teacher'){
    $admmenu = [['Показать уроки','listlesson'], ['Добавить группу','addgroup'], ['Добавить направление','adddirections']];
    $qar = querydb("SELECT psel_lessons.*, psel_directions.title FROM psel_lessons, psel_directions WHERE psel_lessons.date >= '".$datafirstdayweek."' AND psel_lessons.id_derections = psel_directions.id_dir",'arrpl');
}else{
    $qar = querydb("SELECT psel_lessons.*, psel_directions.title FROM psel_lessons, psel_directions WHERE psel_lessons.date >= '".$datafirstdayweek."' AND psel_lessons.id_group = '".$INFOUSER['id_group']."' AND psel_lessons.id_derections = psel_directions.id_dir",'arrpl');
}
?>
<div class="section-1 titlepageHome">
    <div class="titlePage">Расписание уроков</div>
    <div class="wrapradiosection">
        <?
            for($i=0; $i < count($admmenu);$i++){
                echo'<a href="/el/'.$admmenu[$i][1].'"><div class="radiosection1">'.$admmenu[$i][0].'</div></a>';
            }
        ?>
    </div>
</div>
<div class="section-2 pagination-moth stylesection">
    <div class="arrowleft" onclick="loaddaylessonWeek('left','<?=$firstdayweek?>');"><i></i></div>
    <div class="titlemoth"><div><?=$titleMoth?></div></div>
    <div class="arrawright" onclick="loaddaylessonWeek('rigth','<?=$firstdayweek?>');"><i></i></div>
</div>
<div class="section-3 homework-user">
    <div class="wrpatitlesection">
        <?for($i=1;$i <= 7;$i++){
            echo'<div class="divtitlesectionactive">';
            if($numberweek == $i){echo'Сегодня';}
            echo'</div>';
        }?>
    </div>
    <div class="wrapper-weekend">
        <?
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
                if($numberweek == $i){echo '<div class="weekend-day active" onclick="loaddaylesson('.$sk.');">';}
                else{echo '<div class="weekend-day" onclick="loaddaylesson('.$sk.',this);">';}
                echo'<div class="wrapper_desktopInfo">';
                    echo'<div class="numbermoth-day">'.$dayandmoth.'</div>';
                    echo'<div class="day-week">'.$weeksarr[$i].'</div>';
                    $numlessn = 0;
                    for($q=0; $q < count($qar);$q++){if($qar[$q]['date'] == $sk){$numlessn++;} }
                    $q--;
                    $lasttime = explode('-',$qar[$q]['time']);
                    $numlessn = declOfNum($numlessn, array('урок', 'урока', 'уроков'));
                    if($numlessn == 0){echo'<div class="descriptn">занятия отсутсвуют</div>';}
                    else{echo'<div class="descriptn">'.$numlessn.' <br> до '.$lasttime[1].'</div>';}
                    echo'</div>';
                    echo'<div class="wrapper_mobileInfo">';
                        echo'<div class="day-week">'.$weeksarrsk[$i].'</div>';
                        echo'<div class="numbermoth-day">'.$dayandmothmb.'</div>';
                    echo'</div>';
                echo'</div>';
                $firsday++;
            }
        ?>
    </div>
    <div class="wrap-homwork-table stylesection">
        <table class="tablestyle">
            <thead>
                <tr>
                    <th>Время</th>
                    <th>Тема урока / Направление</th>
                    <th>Место проведение</th>
                    <th>Домашнее задание</th>
                </tr>
            </thead>
            <tbody class="tbodytablehomwork">
                <?
                    $firsday = $arrsfirstdayweek[2];
                    $sk = $yar.$arrsfirstdayweek[1].$today;
                    $nml=0;
                    for($i=0;$i < count($qar);$i++){
                        if($qar[$i]['date'] == $sk){
                            if($INFOUSER['rulse'] == 'admin' || $INFOUSER['rulse'] == 'teacher'){$icoedit='<i class="icoedit" onclick="edit_hmwk_start('.$i.','.$qar[$i]['id_les'].');" title="редактировать домашине задание"></i>';}
                            $arrtime = explode('-', $qar[$i]['time']);
                            echo'<tr>';
                                echo'<th>'.$arrtime[0].' - '.$arrtime[1].'</th>';
                                echo'<th>'.$qar[$i]['title_ls'].' / '.$qar[$i]['title'].'</th>';
                                echo'<th>'.$qar[$i]['venue'].'</th>';
                                echo'<th class="homwork_'.$i.'"><span class="hmw_edittxt_'.$i.'">'.$qar[$i]['homework'].'</span>'.$icoedit.'</th>';
                            echo'</tr>';
                            $nml++;
                        }
                    }
                    if($nml == 0){echo'<tr><th colspan="4">Занятия отсутсвуют</th></tr>';}
                ?>
            </tbody>
        </table>
        <div class="wrappeMobileInterface">
            <?
            for($i=0;$i < count($qar);$i++){
                if($qar[$i]['date'] == $sk){
                    $arrtime = explode('-', $qar[$i]['time']);
                    echo'<div class="wraplesson">';
                        echo'<div class="titleLesson">'.$qar[$i]['title'].'</div>';
                        echo'<div class="titleLesson_tema">'.$qar[$i]['title_ls'].'</div>';
                        echo'<div class="timelesson">'.$arrtime[0].' - '.$arrtime[1].'</div>';
                        echo'<div class="homeworkLesson">'.$qar[$i]['homework'].'</div>';
                    echo'</div>';
                    $nml++;
                }
            }
            if($nml == 0){echo'<div class="wraplesson" style="text-align:center;">Занятия отсутсвуют</div>';}
            ?>
            </div>
        </div>
    </div>
</div>