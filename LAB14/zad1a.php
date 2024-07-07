<?php

class Movie {
    public $ID;
    public $Title;
    public $Director;
    public $ReleaseYear;
    public $Genre;
    public $Rating;

    public function __construct($ID, $Title, $Director, $ReleaseYear, $Genre, $Rating) {
        $this->ID = $ID;
        $this->Title = $Title;
        $this->Director = $Director;
        $this->ReleaseYear = $ReleaseYear;
        $this->Genre = $Genre;
        $this->Rating = $Rating;
    }
}

function loadMoviesFromCSV($filename) {
    $movies = [];
    if (!file_exists($filename)) {
        throw new Exception("Plik nie istnieje.");
    }

    if (($handle = fopen($filename, "r")) !== FALSE) {
        fgetcsv($handle);
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if (count($data) != 6) {
                throw new Exception("Błędny format danych.");
            }
            list($ID, $Title, $Director, $ReleaseYear, $Genre, $Rating) = $data;
            if (empty($ID) || empty($Title) || empty($Director) || empty($ReleaseYear) || empty($Genre) || empty($Rating)) {
                throw new Exception("Puste pola w danych.");
            }
            $movies[] = new Movie($ID, $Title, $Director, $ReleaseYear, $Genre, $Rating);
        }
        fclose($handle);
    } else {
        throw new Exception("Nie można otworzyć pliku.");
    }

    return $movies;
}

$movies = loadMoviesFromCSV('movies.csv');

function renderTable($movies) {
    echo '<table id="moviesTable">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Tytuł</th>';
    echo '<th>Reżyser</th>';
    echo '<th><button onclick="sortTable(3)">Rok Wydania</button></th>';
    echo '<th>Gatunek</th>';
    echo '<th><button onclick="sortTable(5)">Ocena</button></th>';
    echo '<th>Akcje</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    foreach ($movies as $movie) {
        echo '<tr>';
        echo '<td>' . $movie->ID . '</td>';
        echo '<td>' . $movie->Title . '</td>';
        echo '<td>' . $movie->Director . '</td>';
        echo '<td>' . $movie->ReleaseYear . '</td>';
        echo '<td>' . $movie->Genre . '</td>';
        echo '<td>' . $movie->Rating . '</td>';
        echo '<td><button onclick="editMovie(' . $movie->ID . ')">Edytuj</button></td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
}

function editMovie($movie) {
    echo '<form method="POST" action="update_movie.php">';
    echo '<label for="ID">ID:</label>';
    echo '<input type="hidden" name="ID" value="' . $movie['ID'] . '">';
    echo '<input type="text" name="ID" value="' . $movie['ID'] . '" readonly><br>';

    echo '<label for="Title">Tytuł:</label>';
    echo '<input type="text" name="Title" value="' . $movie['Title'] . '"><br>';

    echo '<label for="Director">Reżyser:</label>';
    echo '<input type="text" name="Director" value="' . $movie['Director'] . '"><br>';

    echo '<label for="ReleaseYear">Rok Wydania:</label>';
    echo '<input type="number" name="ReleaseYear" value="' . $movie['ReleaseYear'] . '"><br>';

    echo '<label for="Genre">Gatunek:</label>';
    echo '<input type="text" name="Genre" value="' . $movie['Genre'] . '"><br>';

    echo '<label for="Rating">Ocena:</label>';
    echo '<input type="number" step="0.1" name="Rating" value="' . $movie['Rating'] . '"><br>';

    echo '<input type="submit" value="Edytuj">';
    echo '</form>';
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Filmy</title>
    <script>
        function sortTable(column) {
            var table, rows, switching, i, x, y, shouldSwitch;
            table = document.getElementById("moviesTable");
            switching = true;
            while (switching) {
                switching = false;
                rows = table.rows;
                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("TD")[column];
                    y = rows[i + 1].getElementsByTagName("TD")[column];
                    if (column === 3 || column === 5) {
                        if (parseFloat(x.innerHTML) > parseFloat(y.innerHTML)) {
                            shouldSwitch = true;
                            break;
                        }
                    } else {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                }
            }
        }
    </script>
</head>
<body>
    <?php renderTable($movies); ?>
    <h1>Dodaj Nowy Film</h1>
    <form action="add_movie.php" method="post">
        <label for="ID">ID:</label>
        <input type="number" id="ID" name="ID" required><br>
        <label for="Title">Tytuł:</label>
        <input type="text" id="Title" name="Title" required><br>
        <label for="Director">Reżyser:</label>
        <input type="text" id="Director" name="Director" required><br>
        <label for="ReleaseYear">Rok Wydania:</label>
        <input type="number" id="ReleaseYear" name="ReleaseYear" required><br>
        <label for="Genre">Gatunek:</label>
        <input type="text" id="Genre" name="Genre" required><br>
        <label for="Rating">Ocena:</label>
        <input type="number" step="0.1" id="Rating" name="Rating" required><br>
        <input type="submit" value="Dodaj Film">
    </form>
</body>
</html>
