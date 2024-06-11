<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location: ./");
}
?>
<!DOCTYPE html>
<html lang="en">

<?php
$title = "Tasks";
require_once "./partials/head.php";
?>

<body>
    <div class="wrapper">
        <?php require_once "./partials/sidebar.php" ?>

        <div class="main">
            <?php require_once "./partials/topbar.php" ?>

            <main class="content">
                <div class="container-fluid p-0">
                    <h1 class="h3 mb-3">Tasks</h1>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="text-center">Add Task</h3>
                                    <div id="alert"></div>
                                    <form id="add-form">
                                        <div class="row">
                                            <div class="col-md">
                                                <input type="text" class="form-control" name="task-input" id="task-input" placeholder="Please enter the task!">
                                            </div>
                                            <div class="col-md-auto">
                                                <input type="submit" value="Add" class="btn btn-primary">
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="card-body">
                                    <h5>Tasks</h5>
                                    <div id="tasks">
                                        <!-- <div class="row mb-2">
                                            <div class="col-md">
                                                <input type="text" class="form-control" id="task-" value="Database Value" placeholder="Please enter the task!" readonly>
                                            </div>
                                            <div class="col-md-auto">
                                                <button class="btn btn-info" id="edit-" onclick="editTask(1)">Edit</button>
                                            </div>
                                            <div class="col-md-auto">
                                                <button class="btn btn-danger" id="delete-" onclick="deleteTask(1)">Delete</button>
                                            </div>
                                        </div> -->

                                        <!-- <div class="alert alert-info m-0">No record found!</div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <?php require_once "./partials/footer.php" ?>
        </div>
    </div>

    <script src="./template/js/app.js"></script>
    <script src="./template/js/custom.js"></script>
</body>

</html>