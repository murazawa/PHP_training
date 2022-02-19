<?php
session_start();
ini_set('display_errors', "On");
include('../app/_parts/_header.php');
require('../app/user_session.php');

sessionTime();
sessionCheck();

session_destroy();
header('Location: login_form.php');


