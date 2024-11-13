<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Account Reset Password</title>
  <style>
    /* Global Styles */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
    }

    /* Navbar Styles */
    .navbar {
      background-color: #333;
      color: blue;
      padding: 10px;
    }

    .navbar .container {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    /* Form Styles */
    .panel {
      border: 1px solid #ddd;
      border-radius: 5px;
      padding: 20px;
    }

    .panel-title {
      margin-top: 0;
    }

    .form-control {
      display: block;
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .btn-group {
      display: flex;
      justify-content: flex-end;
      margin-top: 20px;
    }

    .btn {
      padding: 10px 20px;
      font-size: 16px;
      border-radius: 5px;
      cursor: pointer;
    }

    .btn-default {
      background-color: #f1f1f1;
      color: #333;
      margin-right: 10px;
    }

    .btn-primary {
      background-color: #007bff;
      color: #fff;
    }

    /* Responsive Styles */
    @media (max-width: 767px) {
      .container {
        padding: 10px;
      }

      .panel {
        padding: 10px;
      }

      .form-control {
        font-size: 14px;
      }

      .btn {
        font-size: 14px;
      }
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <div class="navbar">
    <div class="container">
      <h1>Event Judging System</h1>
    </div>
  </div>

  <!-- Header -->
  <header class="jumbotron subhead" id="overview">
    <div class="container">
      <h1>Account Reset Password</h1>
    </div>
  </header>

  <!-- Content -->
  <div class="container">
    <div class="panel">
      <h3 class="panel-title">Reset Password</h3>
      <form action="<?php echo $_SERVER['PHP_SELF'] . '?email=' . $email . '&token=' . $token; ?>" method="POST">
        <div class="form-group">
          <label for="password">New Password:</label>
          <input id="password" type="password" name="password" class="form-control" placeholder="New Password" aria-describedby="basic-addon1" required="true" autofocus="true" />
        </div>
        <div class="form-group">
          <label for="confirm_password">Confirm Password:</label>
          <input id="confirm_password" type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" aria-describedby="basic-addon1" required="true" autofocus="true" />
        </div>
        <div class="btn-group">
          <a href="index2.php" type="button" class="btn btn-default">Cancel</a>
          <button name="register" type="submit" class="btn btn-primary">Reset</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <font size="2" class="pull-left"><strong>Event Judging System &middot; 2022 &COPY;</strong></font> <br />
    </div>
  </footer>

  <!-- Scripts -->
  <script src="javascript/jquery1102.min.js"></script>
  <script>
    const toast = document.querySelector('.toast');

    function updateToast(title, body, type) {
      const toastTitle = toast.querySelector('.toast-title');
      const toastBody = toast.querySelector('.toast-body');
      const toastHeader = toast.querySelector('.toast-header');

      toastTitle.innerText = title;
      toastBody.innerText = body;

      if (type === 'success') {
        toastHeader.style.backgroundColor = '#28a745';
      } else if (type === 'warning') {
        toastHeader.style.backgroundColor = '#ffc107';
      } else if (type === 'error') {
        toastHeader.style.backgroundColor = '#dc3545';
      }
    }
  </script>
</body>

</html>