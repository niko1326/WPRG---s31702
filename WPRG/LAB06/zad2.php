<?php
// Pętla generująca tabelę dla każdej podstawy potęgi
for ($i = 1; $i <= 10; $i++) {
    // Nagłówki tabeli dla każdej podstawy
    echo "<table border='1'>";
    echo "<caption>Podstawa = $i</caption>";
    echo "<tr><th>Podstawa</th><th>Wykładnik</th><th>Wynik</th></tr>";

    // Pętla generująca wiersze tabeli dla wykładników potęgi
    for ($j = 2; $j <= 10; $j++) {
        $k = pow($i, $j);
        echo "<tr><td>$i</td><td>$j</td><td>$k</td></tr>";
    }

    // Zamknięcie tabeli dla danej podstawy
    echo "</table>";
}
?>