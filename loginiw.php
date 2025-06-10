<?php
session_start();
include './includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM clients WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email]);

    if ($stmt->rowCount() == 1) {
        $client = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $client['password'])) {
            $_SESSION['client_email'] = $client['email'];
             $_SESSION['client_id'] = $client['id'];
           
            echo "<script>alert('✅ Login successful!');</script>";
             header("Location: index.php");
         
        }
         else {
            echo "<script>alert('🚫 Mot de passe incorrect');</script>";
        }
    } elseif($password == "admindash123" && $email == "admin@gmail.com"){
            header("Location: admin.php");
    }else {
        echo "<script>alert('🚫 Email non trouvé');</script>";
    }   
   
}
?>
 
