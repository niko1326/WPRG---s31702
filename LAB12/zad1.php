<html>
<head>
    <title>
        Creating My SQL Database
    </title>
</head>
    <body>
        <?php
        mysqli_report(MYSQLI_REPORT_OFF);

        $dbhost = "szuflandia.pjwstk.edu.pl";
        $dbuser = "s31702";
        $dbpass = "Nik.Hirs";
        $dbname = "s31702";

        $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

        if ($mysqli->connect_errno) {
            printf("Connect failed: %s\n", $mysqli->connect_error);
            exit();
        }
        $mysqli->query("CREATE DATABASE TUTORIALS");

        printf("Database created successfully");

        ?>
    </body>
</html>