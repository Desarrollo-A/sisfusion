<?php
    //Include Google Client Library for PHP autoload file
    require_once 'vendor/autoload.php';
    
    $google_client  = new Google_Client();
    // Enter your Client ID
    $google_client ->setClientId('161969316544-ou10ee3mktbmp2og21po8rj2eke8ej9t.apps.googleusercontent.com');
    // Enter your Client Secrect
    $google_client ->setClientSecret('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');
    // Enter the Redirect URL
    $google_client ->setRedirectUri('http://localhost/sisfusion/Dashboard/dashboard');
    // Adding those scopes which we want to get (email & profile Information)
    $google_client ->addScope("email");
    $google_client ->addScope("profile");
    $google_client ->addScope("https://www.googleapis.com/auth/calendar");

?>