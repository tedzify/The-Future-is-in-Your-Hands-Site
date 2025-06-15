<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="src/css/AdminLogin.css" />
    <title>Admin Register</title>
  </head>
  <body>
    <div class="login container">
      <div class="box form-box">
        <?php 
          include 'includes/connect.php';

if (isset($_POST['submit'])) {
    // Retrieve form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $auth_key_input = $_POST['auth_key'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match.');</script>";
    } else {
        // Check if email already exists
        $email_check_query = "SELECT id FROM acc_admin WHERE email = ?";
        $stmt = $conn->prepare($email_check_query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $email_check_result = $stmt->get_result();

        if ($email_check_result->num_rows > 0) {
            echo "<div class='message'>
                    <p>This email already exists</p>
                  </div><br>";
            echo "<a href='javascript:self.history.back()'>
                  <button class='submit-btn'>Go Back</button>";
        } else {
            // Hash the password for security
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Validate the authentication key
            $auth_key_query = "SELECT id FROM auth_key WHERE auth_key = ?";
            $stmt = $conn->prepare($auth_key_query);
            $stmt->bind_param("s", $auth_key_input);
            $stmt->execute();
            $auth_key_result = $stmt->get_result();

            if ($auth_key_result->num_rows > 0) {
                // Fetch the auth_key_ID
                $auth_key_row = $auth_key_result->fetch_assoc();
                $auth_key_ID = $auth_key_row['id'];

                // Insert new admin into acc_admin table
                $insert_query = "INSERT INTO acc_admin (username, email, password, auth_key_ID) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($insert_query);
                $stmt->bind_param("sssi", $username, $email, $hashed_password, $auth_key_ID);

                if ($stmt->execute()) {
                    echo "<div class='message-success'>
                            <p>Registered Successfully</p>
                          </div><br>";
                    echo "<a href='AdminLogin'>
                          <button class='submit-btn'>Login Now</button>";
                } else {
                    echo "<div class='message'>
                            <p>Failed to Register</p>
                          </div><br>";
                    echo "<a href='javascript:self.history.back()'>
                          <button class='submit-btn'>Go Back</button>";
                }
            } else {
                echo "<div class='message'>
                        <p>Invalid Authentication Key</p>
                      </div><br>";
                echo "<a href='javascript:self.history.back()'>
                      <button class='submit-btn'>Go Back</button>";
            }
        }
    }
} else {
        ?>
        <header>Register</header>
        <form action="" method="post">
          <div class="input field">
            <label for="username">Username</label>
            <input
              type="text"
              name="username"
              id="username"
              placeholder="Enter Username"
              autocomplete="off"
              required
            />
          </div>
          <div class="input field">
            <label for="email">Email</label>
            <input
              title="Must be a valid email address."
              pattern="((?!\.)[\w\-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])"
              type="email"
              name="email"
              id="email"
              placeholder="Enter Email"
              required
              autocomplete="off"
            />
          </div>
          <div class="input field">
            <label for="password">Password</label>
            <input
              title="Must contain at least 8 characters. 1 uppercase, 1 lowercase letter, a number and no spaces."
              pattern="((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{6,})\S"
              type="password"
              name="password"
              id="password"
              placeholder="Enter Password"
              autocomplete="off"
              required
            />
          </div>
          <div class="input field">
            <label for="confirm_password">Confirm Password</label>
            <input
              type="password"
              name="confirm_password"
              id="confirm_password"
              autocomplete="off"
              placeholder="Confirm Password"
              required
            />
          </div>
          <div class="input field">
            <label for="auth_key">Authentication Key</label>
            <input
              title="Given to admins only"
              type="password"
              name="auth_key"
              id="auth_key"
              autocomplete="off"
              placeholder="Enter Authentication Key"
              required
            />
          </div>
          <div class="input field button">
            <input
              class="submit-btn"
              type="submit"
              name="submit"
              value="Register"
              required
            />
          </div>
          <div class="links">
            Already registered?
            <a href="AdminLogin">Sign in</a>
          </div>
        </form>
      </div>
      <?php } ?>
    </div>
  </body>
</html>
