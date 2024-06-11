<?php
session_start();
require_once "../partials/connection.php";
$_POST = json_decode(file_get_contents("php://input"), true);
if (isset($_POST['submit'])) {
    $task = htmlspecialchars($_POST['task']);
    $id = $_SESSION['user']['id'];
    if (empty($task)) {
        echo json_encode([
            'taskError' => "Task is required from PHP"
        ]);
    } else {
        $sql = "INSERT INTO `tasks`(`task`, `user_id`) VALUES ('$task', '$id');";
        
        if ($conn->query($sql)) {
            echo json_encode([
                'success' => "Magic has been spelled!"
            ]);
        } else {
            echo json_encode([
                'failure' => "Magic has failed to spell!"
            ]);
        }
    }
}
