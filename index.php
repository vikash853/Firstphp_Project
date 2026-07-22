<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Summer Vacation — Form</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">

    <h1>Augurs Technologies</h1>
    <h2>Welcome to Summer Vacation</h2>
    

    <form action="index.php" method="POST">

      <input type="text"  name="name"   placeholder="Full Name"      required>
      <input type="text"  name="id"     placeholder="Register ID"    required>

      <label for="gender-select">Gender</label>
      <select id="gender-select" name="gender" required>
        <option value="" disabled selected>Choose your gender</option>
        <option value="male">Male</option>
        <option value="female">Female</option>
         <option value="LGBTQ+">LGBTQ+</option>                                
        <option value="other">Other</option>
      </select>

      <input type="tel"   name="phone"  placeholder="Phone Number"   required>
      <input type="email" name="email"  placeholder="Email Address"  required>

      <button type="submit" name="submit">Register Now</button>

    </form>
  


<?php

require_once 'config.php';
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name   = trim(htmlspecialchars($_POST['name']));
    $id     = trim(htmlspecialchars($_POST['id']));
    $gender = trim(htmlspecialchars($_POST['gender']));
    $phone  = trim(htmlspecialchars($_POST['phone']));
    $email  = trim(htmlspecialchars($_POST['email']));

    // Basic validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<p class='error'>Invalid email address.</p>";
    } elseif (!preg_match('/^\+?[0-9]{7,15}$/', $phone)) {
        $message = "<p class='error'>Invalid phone number.</p>";
    } else {
        $stmt = mysqli_prepare($connection,
            "INSERT INTO mydata (name, registerid, gender, phone, email) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssss", $name, $id, $gender, $phone, $email);

        if (mysqli_stmt_execute($stmt)) {
            $message = "<p class='success'>Registration successful!</p>";
        } else {
            $message = "<p class='error'>Error: " . mysqli_stmt_error($stmt) . "</p>";
        }
        mysqli_stmt_close($stmt);
    }
}
mysqli_close($connection);
?>

  </div>
</body>
</html>
