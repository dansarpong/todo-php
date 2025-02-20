<?php
// index.php
require_once 'config.php';

// Process form submission for adding a new task or deleting one
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Delete a task if delete_id is set
    if (isset($_POST['delete_id'])) {
        $id = intval($_POST['delete_id']);
        $stmt = $db->prepare("DELETE FROM todos WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: index.php");
        exit;
    }
    // Add a new task if 'task' is provided
    if (isset($_POST['task'])) {
        $task = trim($_POST['task']);
        if ($task !== '') {
            $stmt = $db->prepare("INSERT INTO todos (task) VALUES (?)");
            $stmt->execute([$task]);
        }
        header("Location: index.php");
        exit;
    }
}

// Retrieve all todos from the database
$stmt = $db->query("SELECT * FROM todos ORDER BY id DESC");
$todos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Todo App</title>
    <link rel="stylesheet" href="static/styles.css">
</head>
<body>
    <h1>Todo List</h1>
    <form method="post" action="index.php">
        <input type="text" name="task" placeholder="Enter new task" required>
        <button type="submit">Add</button>
    </form>
    <ul>
        <?php foreach($todos as $todo): ?>
            <li>
                <?php echo htmlspecialchars($todo['task']); ?>
                <form method="post" action="index.php" style="display:inline;">
                    <input type="hidden" name="delete_id" value="<?php echo $todo['id']; ?>">
                    <button type="submit">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
