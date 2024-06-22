<?php
// index.php
require 'config.php';

// Function to fetch all tasks
function fetchTasks($pdo, $search = '', $status = '')
{
    $query = "SELECT * FROM tasks WHERE 1";
    if ($search) {
        $query .= " AND title LIKE :search";
    }
    if ($status) {
        $query .= " AND status = :status";
    }
    $stmt = $pdo->prepare($query);
    if ($search) {
        $stmt->bindValue(':search', "%$search%");
    }
    if ($status) {
        $stmt->bindValue(':status', $status);
    }
    $stmt->execute();
    return $stmt->fetchAll();
}

// Function to add a new task
function addTask($pdo, $title, $description)
{
    $stmt = $pdo->prepare("INSERT INTO tasks (title, description) VALUES (:title, :description)");
    $stmt->execute(['title' => $title, 'description' => $description]);
}

// Function to update task status
function updateTaskStatus($pdo, $id, $status)
{
    $stmt = $pdo->prepare("UPDATE tasks SET status = :status WHERE id = :id");
    $stmt->execute(['status' => $status, 'id' => $id]);
}

// Handle form submission for adding a new task
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_task'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    addTask($pdo, $title, $description);
    header('Location: index.php');
    exit;
}

// Handle status update
if (isset($_GET['update_status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];
    updateTaskStatus($pdo, $id, $status);
    header('Location: index.php');
    exit;
}

// Fetch tasks based on search and filter
$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? '';
$tasks = fetchTasks($pdo, $search, $status);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mb-5">
        <h1 class="mt-5">Task Manager</h1>

        <form method="POST" class="mb-4">
            <h2>Add New Task</h2>
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" class="form-control" required></textarea>
            </div>
            <button type="submit" name="add_task" class="btn btn-primary">Add Task</button>
        </form>

        <form method="GET" class="mb-4">
            <h2>Search Tasks</h2>
            <div class="form-group">
                <label for="search">Search by Title:</label>
                <input type="text" id="search" name="search" value="<?= htmlspecialchars($search) ?>" class="form-control">
            </div>
            <div class="form-group">
                <label for="status">Filter by Status:</label>
                <select id="status" name="status" class="form-control">
                    <option value="">All</option>
                    <option value="Pending" <?= $status === 'Pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="In Progress" <?= $status === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                    <option value="Completed" <?= $status === 'Completed' ? 'selected' : '' ?>>Completed</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <h2>Task List</h2>
        <ul class="list-group">
            <?php foreach ($tasks as $task) : ?>
                <li class="list-group-item">
                    <strong><?= htmlspecialchars($task['title']) ?></strong>
                    - <span class="badge badge-info"><?= htmlspecialchars($task['status']) ?></span>
                    <div class="mt-2">
                        <a href="?update_status&id=<?= $task['id'] ?>&status=Pending" class="btn btn-secondary btn-sm">Set to Pending</a>
                        <a href="?update_status&id=<?= $task['id'] ?>&status=In Progress" class="btn btn-warning btn-sm">Set to In Progress</a>
                        <a href="?update_status&id=<?= $task['id'] ?>&status=Completed" class="btn btn-success btn-sm">Set to Completed</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>