<?php
    //DB configuration variables for site
    define("HOST", "localhost");
    define("DBNAME", "SampleDB01");
    define("DBUSER", "DBUser123");
    define("PWD", "sample%data~!");
    $dbc = 0;
    
    //database connection
    $dbc = mysqli_connect(HOST, DBUSER, PWD, DBNAME)
        or die ('Cannot connect to database');

    define("SITE_ROOT_PATH", $_SERVER["DOCUMENT_ROOT"]); //site root path
    define("USER_UPLOAD_DIR", "/lesson4/uploads/"); // HTML uploads path
    define("MAX_FILE_SIZE", 1000 * 1024); //max file upload size in kilobytes * bytes
?>