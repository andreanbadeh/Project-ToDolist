<?php
include 'database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $conn->query("INSERT INTO task_history (task, due_date, status) 
                  SELECT task, due_date, 'completed' FROM tasks WHERE id=$id");

    $stmt = $conn->prepare("UPDATE tasks SET status='completed' WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}
?>

