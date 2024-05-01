<?php
function chektext($val)
{
    return trim(strip_tags(htmlspecialchars($_POST[$val])));
}
function jsonecho($tttt, $rs = 'er')
{
    if ($rs == 'sc') {
        $k = "seccess";
    } else {
        $k = "error";
    }
    echo json_encode(array($k => $tttt));
}
function chektextST($val)
{
    return trim(strip_tags(htmlspecialchars($val)));
}
function generateCode($length = 6)
{
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
        $code .= $chars[mt_rand(0, $clen)];
    }
    return $code;
}
function arrastr($str, $del1)
{
    $arres = array();
    $str = explode($del1, $str);
    foreach ($str as $key => $value) {
        $kps = explode('=', $value);
        $arres[$kps[0]] = $kps[1];
    }
    return $arres;
}
function routing_url($req)
{
    if (stripos($req, '?') !== false) {
        $rss = stristr($req, '?', true);
    } else $rss = $req;
    $ar = explode('/', $rss);
    if (count($ar) > 1) {
        $ls = '';
        for ($i = 0; $i < count($ar); $i++) {
            $ls = $ar[$i];
        }
        return $ls;
    } else return NULL;
}
function routing_page($rt, $str)
{
    $fp = fopen('pages/' . $rt . '.php', 'r');
    $i = (int)$str;
    $strings = [];
    while ($i--) {
        $strings[] = fgets($fp, 1000);
    }
    return $strings;
}
function therepage($rs)
{
    if (!file_exists('pages/' . $rs . '.php')) return 'nopage';
    else return 'yespage';
}
function declOfNum($num, $titles)
{
    $cases = array(2, 0, 1, 1, 1, 2);
    return $num . " " . $titles[($num % 100 > 4 && $num % 100 < 20) ? 2 : $cases[min($num % 10, 5)]];
}
function dateforamtirs($date, $time,$rs=' '){
    $yaer = mb_substr($date, 0, 4);
    $moth = mb_substr($date, 4, 5);
    if (strlen($date) == 6 || strlen($date) == 7) {
        if(strlen($date) == 6){$moth = mb_substr($date, 4, -1);}
        if(strlen($date) == 7){$moth = mb_substr($date, 4, -2);}
    }
    if($moth > 13){
        $moth = mb_substr($date, 4, -2);
    }
    if($moth < 10) $moth = '0'.$moth;
    $day = mb_substr($date, 5, 6);
    if(strlen($date) == 8){$day = mb_substr($date, 6, 7);}
    if($day < 10) $day = '0'.$day;
    if($rs == 'ar'){
        $timear = explode(':', $time);
        return ["yar"=>$yaer,"moth"=>$moth,"day"=>$day,"hours"=>$timear[0],"min"=>$timear[1]];
    }else{
        $result = $yaer.$rs.$moth.$rs.$day;
        return $result.'T'.$time;
    }
}
