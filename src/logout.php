<?php
    //Start or continue  with session
    session_start();

    //Destroy current session
    session_destroy();

    //Redirect to login form
    header('refresh:0; url=signin.html');
?>