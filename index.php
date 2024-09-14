<?php

require_once 'TaskManager.php';

$taskManager = new TaskManager();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $id = uniqid();
        $title = $_POST['title'];
        $description = $_POST['description'];
        $task = new Task($id, $title, $description);
        $taskManager->addTask($task);
    } elseif ($action === 'update') {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $status = $_POST['status'];
        $task = new Task($id, $title, $description, $status);
        $taskManager->updateTask($task);
    } elseif ($action === 'delete') {
        $id = $_POST['id'];
        $taskManager->deleteTask($id);
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Task Manager</title>
</head>
<body>
    <h1>Task Manager</h1>

    <h2>Add Task</h2>
    <form method="post">
        <input type="hidden" name="action" value="add">
        <label>Title: <input type="text" name="title" required></label><br>
        <label>Description: <textarea name="description" required></textarea></label><br>
        <button type="submit">Add Task</button>
    </form>

    <h2>All Tasks</h2>
    <ul>
        <?php foreach ($taskManager->getAllTasks() as $task): ?>
            <li>
                <strong><?php echo htmlspecialchars($task->getTitle()); ?></strong><br>
                <?php echo htmlspecialchars($task->getDescription()); ?><br>
                Status: <?php echo htmlspecialchars($task->getStatus()); ?>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($task->getId()); ?>">
                    <button type="submit">Delete</button>
                </form>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($task->getId()); ?>">
                    <label>Title: <input type="text" name="title" value="<?php echo htmlspecialchars($task->getTitle()); ?>" required></label><br>
                    <label>Description: <textarea name="description" required><?php echo htmlspecialchars($task->getDescription()); ?></textarea></label><br>
                    <label>Status: 
                        <select name="status">
                            <option value="pending" <?php echo $task->getStatus() === 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="completed" <?php echo $task->getStatus() === 'completed' ? 'selected' : ''; ?>>Completed</option>
                        </select>
                    </label><br>
                    <button type="submit">Update Task</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
