<div class="section-1 titlepageHome">
    <div class="titlePage">Достижения и рейтинг</div>
</div>
<div class="wrap-grade-table stylesection" style="border-radius:10px;margin-bottom:15px;min-height:90px;padding:20px 55px;">
    <div class="titlemoth">Ваши сертификаты</div>
    <div class="titlemoth"style="text-align:center;margin:0 auto;min-height:90px;box-sizing:border-box;padding-top:30px;">Сертификаты отсутсвуют</div>
</div>
<?
$idgrouDefault = 3;
if($INFOUSER['rulse'] == 'admin' || $INFOUSER['rulse'] == 'teacher'){ $idgrou_les = $idgrouDefault; }
else{ $idgrou_les = $INFOUSER['id_group']; }
$slUsers = querydb("SELECT id,name,familia,id_group FROM `psel_users` WHERE `id_group` = '".$idgrou_les."'",'arrpl');
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
    if($INFOUSER['rulse'] == 'admin' || $INFOUSER['rulse'] == 'teacher'){
        $qar_group = querydb("SELECT * FROM psel_grouppart",'arrpl');
        echo'<div class="wrap-grade-table stylesection" style="border-radius:10px;margin-bottom:15px;min-height:90px;padding:20px 55px;">';
            echo '<div class="titlemoth" style="margin-bottom:15px;">Выберите группу</div>';
            echo'<select name="group_select" class="style_selectForms group_select">';
                for($i=0;$i < count($qar_group);$i++){
                    $sel='';
                    if($qar_group[$i]['id_gr'] == $idgrouDefault) $sel='selected';
                    echo'<option value="'.$qar_group[$i]['id_gr'].'" '.$sel.'>'.$qar_group[$i]['title'].'</option>';
                }
            echo '</select>';
            echo'<button class="default_btn" onclick="load_group_rating()">Загрузить</button>';
        echo '</div>';
    }

?>
<div class="wrap-grade-table stylesection" style="border-radius:10px;min-height:90px;padding:20px 55px;">
    <div class="titlemoth" style="margin-bottom: 36px">Рейтинг</div>
    <table class="table_rating">
        <thead>
            <tr>
                <th>Место</th>
                <th>Фамилия Имя</th>
                <th>Количество баллов</th>
            </tr>
        </thead>
        <tbody class="body_insterInnfo_rating">
            <?
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
            ?>
        </tbody>
    </table>
</div>