<html>
<head><title>Creating MySQL Table</title></head>
<body>
<?php
mysqli_report(MYSQLI_REPORT_OFF);

$dbhost = "szuflandia.pjwstk.edu.pl";
$dbuser = "s31702";
$dbpass = "Nik.Hirs";
$dbname = "s31702";
$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($mysqli->connect_errno) {
    printf(
        "Connect failed: %s<br />", $mysqli->connect_error);
    exit();
}
printf('Connected successfully.<br />');
$sql = "CREATE TABLE tutorials_tbl( " .
    "tutorial_id INT NOT NULL AUTO_INCREMENT, " .
    "tutorial_title VARCHAR(100) NOT NULL, " .
    "tutorial_author VARCHAR(40) NOT NULL, " .
    "submission_date DATE, " .
    "PRIMARY KEY ( tutorial_id )); ";
if ($mysqli->query($sql)) {
    printf("Table tutorials_tbl created successfully.<br />");
}
if
($mysqli->errno) {
    if ($mysqli->query("DROP TABLE tutorials_tbl")) {
        printf("Table tutorials_tbl dropped succesfully");
    } else {
        printf("Could not create table: %s<br />", $mysqli->error);
    }
}
$mysqli->close();
?>
</body>
</html>