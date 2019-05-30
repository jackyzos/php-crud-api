<?php   include('inc/header.php');

if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
  echo '<p class="notification is-danger">' . $_SESSION['message'] . '</p>';
}
      if (isset($_POST['submit'])) {
        require_once("inc/connection.php");
      if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $password = mysqli_real_escape_string($db, $_POST['password']);
        $sql ="SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($db, $sql);
        // $rows = mysqli_num_rows($result);
        if(mysqli_num_rows($result) > 0){
          while ($row = mysqli_fetch_array($result)) {
            if (password_verify($password, $row['password'])) {
              $_SESSION['user'] = $username;
              $_SESSION['userID'] = $row['id'];
                if (isset($_SESSION['user'])) {
                  header('Location: index.php');
                }

              }else {
                echo 'wrong password';
              }
          }
          // if (password_verify($_POST['password'], PASSWORD_DEFAULT)) {
          //   $_SESSION['user'] = $username;
          //   if (isset($_SESSION['user'])) {
          //     header('Location: index.php');
          //   }
          // }else {
          //   echo 'password is wrong';
          // }
        }else {
            echo 'this username does not exist'.'<br>';
            echo '<a href="index.php">Go back</a>';
            mysqli_close($db);
          }




      // if ($user == $_POST['email'] && $password == $_POST['password']) {
      //   $_SESSION['user'] = $user;
      //   if (isset($_SESSION['user'])) {
      //   header('Location: index.php');
      //   }
      // }else {
      //   echo 'incorrect Email/password'.'<br>';
      //   echo '<a href="index.php">Go back</a>';
      // }
      }else {
        echo 'empty string'.'<br>';
        echo '<a href="index.php">Go back</a>';
      }
      }else {
        ?>
        <div class="columns is-mobile">
          <div class="column is-half is-offset-one-quarter">
            <div class="title">
              Sign in
            </div>
        <form class="" action="login.php" method="post">
          <div class="field">
            <label class="label">Username</label>
            <div class="control">
              <input class="input" type="text" name="username">
            </div>
          </div>
          <div class="field">
          <label class="label">Password</label>
          <div class="control">
          <input class="input" name="password" type="password">
          </div>
          </div>
            <div class="field is-grouped">
              <div class="control">
                <button class="button is-link" name="submit">Login</button>
              </div>
              <div class="control">
                <button class="button is-text">Cancel</button>
              </div>
            </div>
        </form>
        <div class="field is-grouped">
          <div class="control">
            <p>Create Account?</p>
            <a class="is-link" href="signup.php" name="submit">Register</a>
          </div>
        </div>
      </div>
    </div>
        <?php
      }
    ?>
<?php   include('inc/footer.php'); ?>
