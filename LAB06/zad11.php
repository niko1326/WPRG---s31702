<head>
    <style>
        #container{
            display: flex;
            flex-direction: row;
        }
    </style>
</head>


<html>

<?php
    echo "<div id='container'>";
        echo "<div id='table1'>";
            echo "<table border='1'>";
            echo "<tr><th>Celsius</th><th>Farenheit</th></tr>";
                for ($i = -30; $i <= 100; $i++) {
                    $f = $i * (9 / 5) + 32;
                    $j = $f;
                    echo "<tr>
                            <td>
                                $i
                            </td>
                            <td>
                                $j
                            </td>
                          </tr>";
                }
            echo "</table>";
        echo "</div>";

        echo "<div id='table2'>";
            echo "<table border='1'>";
            echo "<tr><th>Farenheit</th><th>Celsius</th></tr>";
                for ($i = 120; $i >= -22; $i--) {
                    $f = $i / (9 / 5) - 32;
                    $j = $f;
                    echo "<tr>
                            <td>
                                $i
                            </td>
                            <td>
                                $j
                            </td>
                          </tr>";
                }
            echo "</table>";
        echo "</div>";
    echo "</div>";

?>


</html>