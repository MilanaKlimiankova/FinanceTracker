<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
unset($_SESSION['login']);
unset($_SESSION['id']);
unset($_SESSION['password']);
unset($_SESSION['email']);
 print "<script language='Javascript' type='text/javascript'>
 function reload(){top.location = '../home.html'};
 setTimeout('reload()', 0);
 </script>";
?>