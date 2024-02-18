<?php
    require_once '../helper/session_helper.php';
    SessionHelper::start();
    SessionHelper::destroy();
    header('Location: ../login.php');