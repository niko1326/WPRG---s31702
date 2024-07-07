<html>
<head>
    <title>Creating MySQL Table</title>
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
    printf("Connect failed: %s<br />", $mysqli->connect_error);
    exit();
}
printf('Connected successfully.<br />');

$sql = "CREATE TABLE Student( " .
    "StudentID INT NOT NULL AUTO_INCREMENT, " .
    "Firstname VARCHAR(100) NOT NULL, " .
    "Secondname VARCHAR(40) NOT NULL, " .
    "Salary INT, " .
    "DateofBirth DATE, " .
    "PRIMARY KEY (StudentID))";

$flag=0;

if (array_key_exists('button1', $_POST)) {
    button1($mysqli);
    $flag=1;
}

if($flag==0){
    if ($mysqli->query($sql)) {
        printf("Table Student created successfully.<br />");
    } else {
        printf("Could not create table: %s<br />", $mysqli->error);
    }
}

function button1($mysqli) {
    if ($mysqli->query("DROP TABLE Student")) {
        printf("Table Student dropped successfully.<br />");
    } else {
        printf("Could not drop table: %s<br />", $mysqli->error);
    }
}

$mysqli->close();
?>

<h1>
    Manage MySQL Table</h1>
<form method="post">
    <input type="submit" name="button1" class="button" value="Delete Table" />
</form>

</body>
</html>
