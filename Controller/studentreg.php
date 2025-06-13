<?php
include('../config/database.php');

if (isset($_POST['register'])) {
    
    $firstname = strtolower(trim($_POST['firstname']));
    $lastname = strtolower(trim($_POST['lastname']));
    $username = strtolower(trim($_POST['username']));
    $password = trim($_POST['password']); 
    $confirm_password = trim($_POST['confirm_password']);

 
    if (strlen($password) < 8) {
        echo "<script>
                alert('Password must be at least 8 characters long.');
                window.location.href = '../view/pages/signIn.php';
              </script>";
        exit();
    }
    if ($password !== $confirm_password) {
        echo  "<script>
                alert('Passwords do not match.');
                window.location.href = '../view/pages/signIn.php';
              </script>";
    } else {
        try {
            
            $stmt = $conn->prepare("SELECT * FROM admin WHERE firstname = ? AND lastname = ? AND username = ?");
            $stmt->execute([$firstname, $lastname, $username]);
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                if (!empty($row['password'])) {
                    
                    echo "<script>
                        alert('Already Registered. Please sign in.');
                        window.location.href = '../view/pages/index.php';
                      </script>";
                    exit();
                } else {
                    
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    $updateStmt = $conn->prepare("UPDATE admin SET password = ? WHERE username = ?");
                    $updateStmt->execute([$hashedPassword, $username]);

                    echo "<script>
                        alert('Registration successful. You may now sign in.');
                        window.location.href = '../view/pages/index.php';
                      </script>";
                    exit();
                }
            } else {
                echo "<script>
                    alert('No matching user found. Please contact the administrator.');
                    window.location.href = '../view/pages/index.php';
                  </script>";
                exit();
            }
        } catch (mysqli_sql_exception $e) {
            echo "<script>
                alert('Database error: " . addslashes($e->getMessage()) . "');
                window.location.href = '../view/pages/index.php';
              </script>";
            exit();
        }
    }
}
