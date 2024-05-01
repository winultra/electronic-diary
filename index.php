<?php
include_once('../core/linkbd.php');
include_once('core/lib_function.php');
include_once('inclide_modules/infouser.php');
//4875E5  815AF0  415380
$default_title = 'Электронный дневник';
$page = routing_url($_SERVER["REQUEST_URI"]);
if($page == null) $page = 'home';
if(therepage($page) == 'nopage') $page = 'home';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$default_title?> | ProSov</title>
    <link rel="stylesheet" type="text/css" href="css/style_el.css">
    <link rel="stylesheet" type="text/css" href="css/normalize2.css">
    <link type="image/png" sizes="96x96" rel="icon" href="../images/favicon.png">
    <script type="text/javascript" src="/js/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="preloader">
    <div class='loader loader1'>
        <div>
            <div>
                <div>
                    <div>
                        <div>
                            <div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?
//Подключение модуля авторизации
if(empty($LoginUser) && empty($passUser) && $INFOUSER == NULL){
    include_once('inclide_modules/auth_include.php');
    echo'<script type="text/javascript" src="js/main.js"></script>';
    echo"</body></html>";
    die;
}
include_once('inclide_modules/header_include.php');
echo'<div class="wrapper-content">';
include_once('pages/'.$page.'.php');
echo'</div>';
?>
<?if($INFOUSER['rulse'] == 'admin' || $INFOUSER['rulse'] == 'teacher'){echo'<script type="text/javascript" src="js/mainmanag.js"></script>';}?>
<script type="text/javascript" src="js/main.js"></script>
</body>
</html>