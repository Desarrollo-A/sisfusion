<?php
    //Include Google Client Library for PHP autoload file
    require_once 'vendor/autoload.php';
    
    $client = new Google_Client();
    // Enter your Client ID
    $client ->setClientId('161969316544-ou10ee3mktbmp2og21po8rj2eke8ej9t.apps.googleusercontent.com');
    // Enter your Client Secrect
    $client ->setClientSecret('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');
    // Enter the Redirect URL
    $client ->setRedirectUri('http://localhost/sisfusion/Dashboard/dashboard');
    // Adding those scopes which we want to get (email & profile Information)
    $client ->addScope("email");
    $client ->addScope("profile");
    $client ->addScope("https://www.googleapis.com/auth/calendar");
?>