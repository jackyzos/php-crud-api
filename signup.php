<?php   include('inc/header.php');
      if (isset($_POST['signupform'])) {
      if (!empty($_POST['username']) && !empty($_POST['password'])  && !empty($_POST['boxChecked']) ){
        require_once("inc/connection.php");
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $password = mysqli_real_escape_string($db, $_POST['password']);
        $password2 = mysqli_real_escape_string($db, $_POST['password2']);
        $checkBox = mysqli_real_escape_string($db, $_POST['boxChecked']);
        $password = password_hash($password, PASSWORD_DEFAULT);
          if ($_POST['password'] == $_POST['password2'] && $checkBox == 'yes' ) {
            $check = "SELECT * FROM users WHERE username= '".$username."' ";
            $result = mysqli_query($db, $check);
            $row = mysqli_fetch_assoc($result);
                if ($username==$row['username']){
                  echo 'this username already taken';
                }else {
                  $sql ="INSERT INTO users (username, password) values('$username' ,'$password')";
                   $result = mysqli_query($db, $sql);
                   if ($checkBox) {
                     $_SESSION['message'] = "Your account was created"; // meddelande kommer
                     header("location: index.php");
                   }
                     exit;
                }

            }else {
              echo 'passwords does not match'.'<br>';
              echo '<a href="signup.php">Go back</a>';
            }
      }else {
        echo 'empty string'.'<br>';
        echo '<a href="signup.php">Go back</a>';
      }
      }else {
        ?>
        <div class="columns is-mobile">
          <div class="column is-half is-offset-one-quarter">
            <div class="title">
              Sign up
            </div>
        <form class="" action="signup.php" method="post">
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
          <div class="field">
          <label class="label">Password Repeat</label>
          <div class="control">
          <input class="input" name="password2" type="password">
          </div>
          </div>
          <label class="checkbox">
                <input type="checkbox" name="boxChecked" value="yes">
               <a href="#">I'm Not a Robot</a>
              </label>
            <div class="field is-grouped">
              <div class="control">
                <button class="button is-link" name="signupform">Register</button>
              </div>
              <div class="control">
                <button class="button is-text">Cancel</button>
              </div>
            </div>
        </form>
        <div class="field is-grouped">
          <div class="control">
            <p>Already have Account?</p>
            <a class="is-link" href="login.php">Sign in</a>
          </div>
        </div>
      </div>
    </div>
        <?php
      }
    ?>
<?php   include('inc/footer.php'); ?>
