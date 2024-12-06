<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="src/css/AdminLogin.css" />
    <title>Admin Login</title>
  </head>
  <body>
    <div class="login container">
      <div class="box form-box">
        <?php
            include 'includes/connect.php'; // Include the database connection

            session_start(); // Start the session

        if (isset($_POST['submit'])) {
            // Retrieve form data
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Prepare and execute the query to fetch the admin details
            $query = "SELECT id, password FROM acc_admin WHERE username = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $admin = $result->fetch_assoc();

                if (password_verify($password, $admin['password'])) {
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['username'] = $username;

                    // Set a cookie for persistent login
                    setcookie("admin_id", $admin['id'], time() + (86400 * 30), "/"); // 30 days

                    header("Location: CandidatesList");
                    exit();
                } else {
                    echo "<div class='message'><p>Invalid password.</p></div><br>";
                    echo "<a href='AdminLogin'>
                          <button class='submit-btn'>Go Back</button>";
                }
            } else {
                echo "<div class='message'><p>No admin found with that username.</p></div><br>";
                echo "<a href='AdminLogin'>
                      <button class='submit-btn'>Go Back</button>";
            }
        } else {
        ?>
        <header>Login</header>
        <form action="" method="post">
          <div class="input field">
            <label for="username">Username</label>
            <input
              type="text"
              name="username"
              id="username"
              placeholder="Enter Username"
              required
            />
          </div>
          <div class="input field">
            <label for="password">Password</label>
            <input
              type="password"
              name="password"
              id="password"
              placeholder="Enter Password"
              required
            />
          </div>
          <div class="input field button">
            <input
              class="submit-btn"
              type="submit"
              name="submit"
              value="Login"
              required
            />
          </div>
          <div class="links">
            Are you a new admin?
            <a href="AdminRegister">Create an account</a>
          </div>
        </form>
      </div>
      <?php } ?>
    </div>
  </body>
</html>
