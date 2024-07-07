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

function saveMoviesToCSV($filename, $movies) {
    $file = fopen($filename, 'w');
    fputcsv($file, ['ID', 'Tytuł', 'Reżyser', 'Rok Wydania', 'Gatunek', 'Ocena']);
    foreach ($movies as $movie) {
        fputcsv($file, [$movie->ID, $movie->Title, $movie->Director, $movie->ReleaseYear, $movie->Genre, $movie->Rating]);
    }
    fclose($file);
}

function renderEditForm($movie) {
    echo '<div id="editMovie">';
    echo '<h1>Edytuj Film</h1>';
    echo '<form method="POST" action="' . $_SERVER['PHP_SELF'] . '">';
    echo '<input type="hidden" name="edit" value="1">';
    echo '<input type="hidden" name="ID" value="' . $movie->ID . '">';
    echo '<label for="Title">Tytuł:</label>';
    echo '<input type="text" name="Title" value="' . $movie->Title . '"><br>';
    echo '<label for="Director">Reżyser:</label>';
    echo '<input type="text" name="Director" value="' . $movie->Director . '"><br>';
    echo '<label for="ReleaseYear">Rok Wydania:</label>';
    echo '<input type="number" name="ReleaseYear" value="' . $movie->ReleaseYear . '"><br>';
    echo '<label for="Genre">Gatunek:</label>';
    echo '<input type="text" name="Genre" value="' . $movie->Genre . '"><br>';
    echo '<label for="Rating">Ocena:</label>';
    echo '<input type="number" step="0.1" name="Rating" value="' . $movie->Rating . '"><br>';
    echo '<input type="submit" value="Edytuj">';
    echo '</form>';
    echo '</div>';
}

function renderAddForm() {
    echo '<div id="addFormContainer">';
    echo '<h1>Dodaj Nowy Film</h1>';
    echo '<form method="POST" action="">';
    echo '<input type="hidden" name="add" value="1">';
    echo '<label for="ID">ID:</label>';
    echo '<input type="number" id="ID" name="ID" required><br>';
    echo '<label for="Title">Tytuł:</label>';
    echo '<input type="text" id="Title" name="Title" required><br>';
    echo '<label for="Director">Reżyser:</label>';
    echo '<input type="text" id="Director" name="Director" required><br>';
    echo '<label for="ReleaseYear">Rok Wydania:</label>';
    echo '<input type="number" id="ReleaseYear" name="ReleaseYear" required><br>';
    echo '<label for="Genre">Gatunek:</label>';
    echo '<input type="text" id="Genre" name="Genre" required><br>';
    echo '<label for="Rating">Ocena:</label>';
    echo '<input type="number" step="0.1" id="Rating" name="Rating" required><br>';
    echo '<input type="submit" value="Dodaj Film">';
    echo '</form>';
    echo '</div>';
}

$filename = 'movies.csv';
$movies = loadMoviesFromCSV($filename);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        // Add new movie
        $newMovie = new Movie($_POST['ID'], $_POST['Title'], $_POST['Director'], $_POST['ReleaseYear'], $_POST['Genre'], $_POST['Rating']);
        $movies[] = $newMovie;
        saveMoviesToCSV($filename, $movies);
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } elseif (isset($_POST['edit'])) {
        foreach ($movies as &$movie) {
            if ($movie->ID == $_POST['ID']) {
                $movie->Title = $_POST['Title'];
                $movie->Director = $_POST['Director'];
                $movie->ReleaseYear = $_POST['ReleaseYear'];
                $movie->Genre = $_POST['Genre'];
                $movie->Rating = $_POST['Rating'];
                break;
            }
        }
        saveMoviesToCSV($filename, $movies);
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <link href="s31702_WPRG.css" type="text/css" rel="stylesheet">
    <title>Filmy</title>
</head>
<body>
<div id="header">Baza Danych Filmów</div>
<div id="container">
    <table id="moviesTable">
        <thead>
        <tr>
            <th>ID</th>
            <th>Tytuł</th>
            <th>Reżyser</th>
            <th>Rok Wydania</th>
            <th>Gatunek</th>
            <th>Ocena</th>
            <th>Akcje</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($movies as $movie) {
            echo '<tr>';
            echo '<td>' . $movie->ID . '</td>';
            echo '<td>' . $movie->Title . '</td>';
            echo '<td>' . $movie->Director . '</td>';
            echo '<td>' . $movie->ReleaseYear . '</td>';
            echo '<td>' . $movie->Genre . '</td>';
            echo '<td>' . $movie->Rating . '</td>';
            echo '<td><button id="editbutton"><a href="?edit=' . $movie->ID . '">Edytuj</a></button></td>';
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
    <?php
    if (isset($_GET['edit'])) {
        $editMovieID = $_GET['edit'];
        $movieToEdit = null;
        foreach ($movies as $movie) {
            if ($movie->ID == $editMovieID) {
                $movieToEdit = $movie;
                break;
            }
        }
        if ($movieToEdit) {
            renderEditForm($movieToEdit);
        }
    } else {
        renderAddForm();
    }
    ?>
</div>

<div id="editFormContainer"></div>

<div id="footer">© 2024 Baza Danych Filmowych</div>
</body>
</html>
