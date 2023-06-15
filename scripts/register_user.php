<?php
session_start();

function filterInput($input)
{
    $input = htmlspecialchars(addslashes(trim($input)));
    return $input;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fields_required = ["FirstName", "LastName", "email", "pass", "confirm_pass", "birthday"];
    $errors = [];
    foreach ($fields_required as $value) {
        if (empty($_POST[$value])) {
            $errors[] = "Pole <b>$value</b> jest wymagane";
        }
    }

    if ($_POST["pass"] != $_POST["confirm_pass"]) {
        $errors[] = "Hasła muszą być identyczne";
    }

    if (!isset($_POST["terms"])) {
        $errors[] = "Zatwierdź regulamin";
    }

    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()-_=+{};:,<.>])(?!.*\s).{4,}$/', $_POST["pass"])) {
        $errors[] = "Hasło nie spełnia wymagań";
    }

    if (!empty($errors)) {
        $_SESSION["error_message"] = implode("<br>", $errors);
        echo "<script>history.back();</script>";
        exit();
    }

    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $additional_email = filterInput($_POST["additional_email"]);
    $firstName = filterInput($_POST["FirstName"]);
    $lastName = filterInput($_POST["LastName"]);
    $birthday = filterInput($_POST["birthday"]);
    $phone_number = filterInput($_POST["phone_number"]);
    $pass = password_hash($_POST["pass"], PASSWORD_ARGON2ID);
    $Role_Id = filterInput($_POST["Role_Id"]);

    require_once "connect.php";
    $sql = 'INSERT INTO `users` (`email`, `Email_Opiekuna`, `FirstName`, `LastName`, `birthday`, `password`, `Numer_Telefonu`, `Role_Id`) VALUES (:email, :additional_email, :FirstName, :LastName, :birthday, :pass, :phone_number, :Role_Id);';

    $sth = $dbh->prepare($sql);
    $sth->bindParam(':email', $email, PDO::PARAM_STR);
    $sth->bindParam(':additional_email', $additional_email, PDO::PARAM_STR);
    $sth->bindParam(':FirstName', $firstName, PDO::PARAM_STR);
    $sth->bindParam(':LastName', $lastName, PDO::PARAM_STR);
    $sth->bindParam(':birthday', $birthday, PDO::PARAM_STR);
    $sth->bindParam(':phone_number', $phone_number, PDO::PARAM_INT);
    $sth->bindParam(':pass', $pass, PDO::PARAM_STR);
    $sth->bindParam(':Role_Id', $Role_Id, PDO::PARAM_INT);

    try {
        $sth->execute();
        if ($sth->rowCount() == 1) {
            $_SESSION["success"] = "Prawidłowo dodano użytkownika $firstName $lastName";
        }
        header("location: ../index.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION["error_message"] = "Nie dodano użytkownika: " . $e->getMessage();
        echo "<script>history.back();</script>";
        exit();
    }
}
