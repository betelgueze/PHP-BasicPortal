<?php
// odhlaseni ze systemu
unset($_SESSION);
header("HTTP/1.1 301 Moved Permanently");
header("Location: index.php");
header("Connection: close");
?>