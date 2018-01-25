<?php

$login = $_POST['login'];
exec("php executa.php $login 2>/dev/null >/dev/null &");

?>