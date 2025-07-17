<?php
session_start();
session_unset();
session_destroy();

<<<<<<< Updated upstream
=======
setcookie("id_user", "", time() - 3600, "/");
setcookie("Uname", "", time() - 3600, "/");
setcookie("role", "", time() - 3600, "/");

>>>>>>> Stashed changes
header("location:../../index.php");