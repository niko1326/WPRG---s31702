<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];
$dataDir = 'data';
$userFile = $dataDir . '/' . $username . '_data.json';

// Ensure data directory exists
if (!file_exists($dataDir)) {
    mkdir($dataDir, 0777, true);
}

// Load user data
if (file_exists($userFile)) {
    $userData = json_decode(file_get_contents($userFile), true);
} else {
    $userData = array(
        'todo_lists' => array(
            'personal' => array(
                'tasks' => array(),
                'completed' => array(),
                'descriptions' => array(),
                'dates' => array(),
                'colors' => array()
            )
        ),
        'current_list' => 'personal'
    );
}

$_SESSION['todo_lists'] = $userData['todo_lists'];
$_SESSION['current_list'] = $userData['current_list'];

$current_list = $_SESSION['current_list'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['task'])) {
        $task = htmlspecialchars($_POST['task']);
        $_SESSION['todo_lists'][$current_list]['tasks'][] = $task;
        $_SESSION['todo_lists'][$current_list]['completed'][] = false;
        $_SESSION['todo_lists'][$current_list]['descriptions'][] = '';
        $_SESSION['todo_lists'][$current_list]['dates'][] = '';
        $_SESSION['todo_lists'][$current_list]['colors'][] = '#333333';
    }

    if (isset($_POST['remove'])) {
        $removeIndex = $_POST['remove'];
        unset($_SESSION['todo_lists'][$current_list]['tasks'][$removeIndex]);
        unset($_SESSION['todo_lists'][$current_list]['completed'][$removeIndex]);
        unset($_SESSION['todo_lists'][$current_list]['descriptions'][$removeIndex]);
        unset($_SESSION['todo_lists'][$current_list]['dates'][$removeIndex]);
        unset($_SESSION['todo_lists'][$current_list]['colors'][$removeIndex]);
        $_SESSION['todo_lists'][$current_list]['tasks'] = array_values($_SESSION['todo_lists'][$current_list]['tasks']);
        $_SESSION['todo_lists'][$current_list]['completed'] = array_values($_SESSION['todo_lists'][$current_list]['completed']);
        $_SESSION['todo_lists'][$current_list]['descriptions'] = array_values($_SESSION['todo_lists'][$current_list]['descriptions']);
        $_SESSION['todo_lists'][$current_list]['dates'] = array_values($_SESSION['todo_lists'][$current_list]['dates']);
        $_SESSION['todo_lists'][$current_list]['colors'] = array_values($_SESSION['todo_lists'][$current_list]['colors']);
        if (isset($_SESSION['selected_task']) && $_SESSION['selected_task'] == $removeIndex) {
            unset($_SESSION['selected_task']);
        } elseif (isset($_SESSION['selected_task']) && $_SESSION['selected_task'] > $removeIndex) {
            $_SESSION['selected_task']--;
        }
    }

    if (isset($_POST['toggle'])) {
        $toggleIndex = $_POST['toggle'];
        $_SESSION['todo_lists'][$current_list]['completed'][$toggleIndex] = !$_SESSION['todo_lists'][$current_list]['completed'][$toggleIndex];
    }

    if (isset($_POST['select'])) {
        $_SESSION['selected_task'] = $_POST['select'];
    }

    if (isset($_POST['update_task'])) {
        $index = $_POST['task_index'];
        $_SESSION['todo_lists'][$current_list]['tasks'][$index] = htmlspecialchars($_POST['name']);
        $_SESSION['todo_lists'][$current_list]['descriptions'][$index] = htmlspecialchars($_POST['description']);
        $_SESSION['todo_lists'][$current_list]['dates'][$index] = htmlspecialchars($_POST['date']);
        $_SESSION['todo_lists'][$current_list]['colors'][$index] = htmlspecialchars($_POST['color']);

        // Save updated session data to JSON file
        $userData = array(
            'todo_lists' => $_SESSION['todo_lists'],
            'current_list' => $_SESSION['current_list']
        );
        if (file_put_contents($userFile, json_encode($userData)) === false) {
            die('Error saving user data.');
        }

        // Redirect to avoid form resubmission issues
        header('Location: index.php');
        exit();
    }


    if (isset($_POST['switch_list'])) {
        $_SESSION['current_list'] = $_POST['switch_list'];
        unset($_SESSION['selected_task']);
    }

    if (isset($_POST['new_list'])) {
        $new_list = htmlspecialchars($_POST['new_list']);
        if (!isset($_SESSION['todo_lists'][$new_list])) {
            $_SESSION['todo_lists'][$new_list] = array(
                'tasks' => array(),
                'completed' => array(),
                'descriptions' => array(),
                'dates' => array(),
                'colors' => array()
            );
        }
        $_SESSION['current_list'] = $new_list;
        unset($_SESSION['selected_task']);
    }

    if (isset($_POST['remove_list'])) {
        $listToRemove = $_POST['remove_list'];
        if ($listToRemove !== 'personal') {
            unset($_SESSION['todo_lists'][$listToRemove]);
            if ($_SESSION['current_list'] == $listToRemove) {
                $_SESSION['current_list'] = 'personal';
                unset($_SESSION['selected_task']);
            }
        }
    }

    $userData = array(
        'todo_lists' => $_SESSION['todo_lists'],
        'current_list' => $_SESSION['current_list']
    );
    if (file_put_contents($userFile, json_encode($userData)) === false) {
        die('Error saving user data.');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ucfirst($_SESSION['current_list']) ?> List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <!-- SIDEBAR (LEFT) -->
    <div class="sidebar">
        <a href="export.php" class="export-button">Export as CSV</a>
        <h3>Lists</h3>
        <ul>
            <?php foreach ($_SESSION['todo_lists'] as $list_name => $list) { ?>
                <li>
                    <form method="post" action="index.php">
                        <input type="hidden" name="switch_list" value="<?php echo $list_name; ?>">
                        <button type="submit" class="list-button"><?php echo ucfirst($list_name); ?></button>
                    </form>
                    <?php if ($list_name !== 'personal') { ?>
                        <form method="post" action="index.php">
                            <input type="hidden" name="remove_list" value="<?php echo $list_name; ?>">
                            <button type="submit" class="remove-button">Remove</button>
                        </form>
                    <?php } ?>
                </li>
            <?php } ?>
            <li>
                <form method="post" action="index.php">
                    <label class="add_list" id="list-form">
                        <input type="text" id="listInput" name="new_list" placeholder="Add New List" required>
                        <button type="submit" id="lower">Add</button>
                    </label>
                </form>
            </li>
        </ul>
    </div>
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <h1><?php echo ucfirst($_SESSION['current_list']); ?> List</h1>
        <form id="todo-form" method="post" action="index.php">
            <input type="text" name="task" id="task" placeholder="Add New Task" required>
            <button type="submit" class="form-button">Add Task</button>
        </form>
        <ul id="todo-list">
            <?php foreach ($_SESSION['todo_lists'][$_SESSION['current_list']]['tasks'] as $index => $task) { ?>
                <li class="<?php echo $_SESSION['todo_lists'][$_SESSION['current_list']]['completed'][$index] ? 'completed' : ''; ?>" style="background-color: <?php echo $_SESSION['todo_lists'][$_SESSION['current_list']]['colors'][$index]; ?>;">
                    <div class="task-item">
                        <form method="post" action="index.php" class="task-form">
                            <input type="hidden" name="toggle" value="<?php echo $index; ?>">
                            <label class="custom-checkbox">
                                <input type="checkbox" <?php echo $_SESSION['todo_lists'][$_SESSION['current_list']]['completed'][$index] ? 'checked' : ''; ?> onclick="this.form.submit()">
                                <span class="checkmark"></span>
                            </label>
                        </form>
                        <span class="task-name">
                            <form method="post" action="index.php" class="task-form select-form">
                                <input type="hidden" name="select" value="<?php echo $index; ?>">
                                <button type="submit" class="select-button"><?php echo $task; ?></button>
                            </form>
                        </span>
                        <form method="post" action="index.php" class="task-form remove-form">
                            <input type="hidden" name="remove" value="<?php echo $index; ?>">
                            <button type="submit" class="remove-button">Remove</button>
                        </form>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
    <!-- SIDEBAR (RIGHT) -->
    <div class="task-details">
        <form method="post" action="logout.php">
            <button type="submit" class="logout-button">Log out</button>
        </form>
        <h2>Task Details</h2>
        <?php
        if (isset($_SESSION['selected_task']) && isset($_SESSION['todo_lists'][$_SESSION['current_list']]['tasks'][$_SESSION['selected_task']])) {
            $selectedTaskIndex = $_SESSION['selected_task'];
            $selectedTask = $_SESSION['todo_lists'][$_SESSION['current_list']]['tasks'][$selectedTaskIndex];
            $selectedDescription = $_SESSION['todo_lists'][$_SESSION['current_list']]['descriptions'][$selectedTaskIndex];
            $selectedDate = $_SESSION['todo_lists'][$_SESSION['current_list']]['dates'][$selectedTaskIndex];
            $selectedColor = $_SESSION['todo_lists'][$_SESSION['current_list']]['colors'][$selectedTaskIndex];
            ?>
            <form method='post' action='index.php'>
                <label for='name'>Name:</label>
                <input type='text' name='name' id='name' value='<?php echo htmlspecialchars($selectedTask); ?>'><br>
                <label for='description'>Description:</label>
                <textarea name='description' id='description' rows='4' cols='50'><?php echo htmlspecialchars($selectedDescription);?></textarea><br>
                <label for='date'>Date:</label>
                <input type='date' name='date' id='date' value='<?php echo htmlspecialchars($selectedDate); ?>'><br>
                <label for='color'>Color:</label>
                <input type='color' name='color' id='color' value='<?php echo htmlspecialchars($selectedColor); ?>'><br>
                <input type='hidden' name='task_index' value='<?php echo $selectedTaskIndex; ?>'>
                <button type='submit' name='update_task'>Update Task</button>
            </form>
        <?php } else {
            echo "<p>Select a task to see details</p>";
        }
        ?>
    </div>
</div>
<script src="script.js"></script>
</body>
</html>
