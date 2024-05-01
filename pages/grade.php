<?
$qi = querydb("SELECT * FROM `psel_grade` WHERE `id_user` = '".$INFOUSER['id']."'","arrpl");
$qads = querydb("SELECT * FROM `psel_absence` WHERE `id_users` = '".$INFOUSER['id']."'","arrpl");
$qidesc = querydb("SELECT * FROM `psel_directions`","noarr");
$admmenu=[];
if($INFOUSER['rulse'] == 'admin' || $INFOUSER['rulse'] == 'teacher'){
    $admmenu = [['Учительский журна','teacherlog']];
}
?>
<div class="section-1 titlepageHome">
    <div class="titlePage">Успеваемость</div>
    <div class="wrapradiosection">
        <?
        for($i=0; $i < count($admmenu);$i++){
                echo'<a href="/el/'.$admmenu[$i][1].'"><div class="radiosection1" style="border-radius:10px;">'.$admmenu[$i][0].'</div></a>';
        }
        ?>
    </div>
</div>
<div class="section-3 homework-user">
    <div class="wrap-grade-table stylesection" style="border-radius:10px;">
        <table class="tablestyle tablestylegrede">
            <thead>
                <tr>
                    <th>Предмет</th>
                    <th>Последние оценки</th>
                    <th>Посещаемость</th>
                    <th>Средний балл</th>
                </tr>
            </thead>
            <tbody>
                <?
                while($rs=mysqli_fetch_assoc($qidesc)){
                    $sumgrade=0;$colgrade=0;$colads=$rs['num_lesson'];
                    echo'<tr>';
                        echo'<th>'.$rs['title'].'</th>';
                        echo'<th class="marks">';
                            for($i=0;$i < count($qi);$i++){
                                if($qi[$i]['id_direc'] == $rs['id_dir']){
                                    echo'<span>'.$qi[$i]['grade'].'</span>';
                                    $sumgrade=$sumgrade+(int)$qi[$i]['grade'];
                                    $colgrade++;
                                }
                            }
                        echo'</th>';
                        for($a=0;$a < count($qads);$a++){
                            if($qads[$a]['id_direc'] == $rs['id_dir']){
                                $colads--;
                            }
                        }
                        echo'<th>'.$colads.' из '.$rs['num_lesson'].'</th>';
                        if($colgrade > 0) $sr=round($sumgrade/$colgrade,1);
                        else $sr=0;
                        echo'<th>'.$sr.'</th>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>