<?php include('inc/header.php');?>
<?php
  if (isset($_SESSION['user']))  {
    if (!empty($_SESSION['userID'])) {
      include('inc/connection.php');
      include('inc/user.php');
      $getUser = User::getUserById($_SESSION['userID']);
      if (isset($_POST['edituserform'])) {
      if (!empty($_POST['password2']) && !empty($_POST['password'])){
      $userID = $_SESSION['userID'];
      $password = $_POST['password'];
      $password2 =  $_POST['password2'];
      $password = password_hash($password, PASSWORD_DEFAULT);
        if ($_POST['password'] == $_POST['password2']) {
            $updatePassword =  User::updateUserPassword($userID,$password);
            echo '<div class="notification is-success">password updated <a href="user_profile.php?uid='.$userID.'">Go back</a></div>';

                   exit;
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
          <br>
          <div class="hero is-info">
          <div class="title">
            My Profile: <?php echo $getUser['username'] ?>
          </div>
        </div>
      <form class="" action="" method="post">
        <div class="field">
          <label class="label">Username</label>
          <div class="control">
            <input class="input" type="text" value="<?php echo $getUser['username']; ?>" disabled="disabled">
          </div>
        </div>
        <label class="label">Update Password</label>
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
          <div class="field is-grouped">
            <div class="control">
              <button class="button is-link" name="edituserform">Save</button>
            </div>
            <div class="control">
              <button class="button is-text">Cancel</button>
            </div>
          </div>
      </form>
      </div>
      </div>
      <?php
      }
    }else {
      echo 'this user is not found';
    }

  }


 ?>
<?php   include('inc/footer.php'); ?>
