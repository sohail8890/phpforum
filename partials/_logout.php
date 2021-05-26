<?php
session_start();
echo "You have been successfully logged out.";
session_destroy();
header("location: /forum")


?>