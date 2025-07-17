<?php
session_start();
session_unset();
session_destroy();

setcookie("id_user", "", time() - 3600, "/");
setcookie("Uname", "", time() - 3600, "/");
setcookie("role", "", time() - 3600, "/");

header("location:../../index.php");