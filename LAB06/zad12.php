<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kształt w zależności od minuty</title>
    <style>
        .shape {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<?php
// Pobierz aktualną minutę
$current_minute = date('i');

// Wybierz kolor kształtu w zależności od minuty
$color = '';
if ($current_minute < 20) {
    $color = 'green'; // Zielony, jeśli minuta jest mniejsza niż 20
} elseif ($current_minute < 40) {
    $color = 'blue'; // Niebieski, jeśli minuta jest mniejsza niż 40
} else {
    $color = 'red'; // Czerwony, jeśli minuta jest większa lub równa 40
}

// Wyświetl kształt z odpowiednim kolorem
echo "<div class='shape' style='background-color: $color;'>$current_minute</div>";
?>
</body>
</html>
