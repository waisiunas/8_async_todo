<?php
session_start();
if (isset($_SESSION['user'])) {
    header("location: ./dashboard.php");
}
require_once "./partials/connection.php";
$name = $email = "";
$errors = [];
if (isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $password_confirmation = htmlspecialchars($_POST['password_confirmation']);

    if (empty($name)) {
        $errors['name'] = "Name is required";
    }

    if (empty($email)) {
        $errors['email'] = "Email is required";
    }

    if (empty($password)) {
        $errors['password'] = "Password is required";
    }

    if ($password !== $password_confirmation) {
        $errors['password'] = "Password does not match";
    }

    if (count($errors) === 0) {
        $sql = "SELECT * FROM `users` WHERE `email` = '$email';";
        $result = $conn->query($sql);

        if ($result->num_rows === 0) {
            $hashed_password = sha1($password);
            $sql = "INSERT INTO `users`(`name`, `email`, `password`) VALUES ('$name', '$email', '$hashed_password');";
            if ($conn->query($sql)) {
                $success = "Magic has been spelled!";
                $name = $email = "";
            } else {
                $failure = "Magic has failed to spell!";
            }
        } else {
            $failure = "Email already exists!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<?php 
$title = "Register";
require_once "./partials/head.php";
?>

<body>
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">

                        <div class="text-center mt-4">
                            <h1 class="h2">Get started</h1>
                            <p class="lead">
                                Start creating the best possible user experience for you customers.
                            </p>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                                    <?php require_once "./partials/alerts.php" ?>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control <?php if (isset($errors['name'])) echo "is-invalid" ?>" id="name" name="name" value="<?php echo $name ?>" placeholder="Name!">
                                        <?php
                                        if (isset($errors['name'])) { ?>
                                            <div class="text-danger">
                                                <?php echo $errors['name'] ?>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control <?php if (isset($errors['email'])) echo "is-invalid" ?>" id="email" name="email" value="<?php echo $email ?>" placeholder="Email!">
                                        <?php
                                        if (isset($errors['email'])) { ?>
                                            <div class="text-danger">
                                                <?php echo $errors['email'] ?>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control <?php if (isset($errors['password'])) echo "is-invalid" ?>" id="password" name="password" placeholder="Password!">
                                        <?php
                                        if (isset($errors['password'])) { ?>
                                            <div class="text-danger">
                                                <?php echo $errors['password'] ?>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>

                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Password Confirmation</label>
                                        <input type="password" class="form-control " id="password_confirmation" name="password_confirmation" placeholder="Password Confirmation!">
                                    </div>

                                    <div class="mb-3">
                                        <input type="submit" name="submit" value="Register" class="btn btn-primary">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="text-center mb-3">
                            Already have account? <a href="./">Log In</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="./template/js/app.js"></script>

</body>

</html>