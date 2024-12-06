<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Header</title>
  </head>
  <body>
    <!-- Navigation Bar -->
    <header>
      <nav class="categories">
        <ul>
          <li>
            <a href="?category=mayor" class="nav-link">Mayor Candidates</a>
          </li>
          <li>
            <a
              href="?category=vice-mayor"
              data-category="vice-mayor"
              class="nav-link"
              >Vice Mayor Candidates</a
            >
          </li>
          <li>
            <a
              href="?category=councilor"
              data-category="councilor"
              class="nav-link"
              >Councilor Candidates</a
            >
          </li>
        </ul>
      </nav>
  <div class="button-container">
    <a href="Homepage" class="back-button">Back to Home</a>
    <?php if (isset($_SESSION['admin_id']) || isset($_COOKIE['admin_id'])): ?>
      <a href="../includes/logout.php" class="login-button">Logout</a>
    <?php else: ?>
      <a href="AdminLogin" class="login-button">Login</a>
    <?php endif; ?>
  </div>
    </header>
  </body>
</html>
