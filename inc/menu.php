<nav class="navbar is-light" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
  <span class="navbar-item">
      <?php echo 'Login as::::   <strong> <a href="user_profile.php?uid='. $_SESSION['userID'].'"> ' . $_SESSION['user'].'</a></strong>'; ?>
  </span>

  <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navMenu">
    <span aria-hidden="true"></span>
    <span aria-hidden="true"></span>
    <span aria-hidden="true"></span>
  </a>
</div>
  <div class="navbar-menu" id="navMenu">
    <div class="navbar-start">
    </div>

    <div class="navbar-end">
      <a class="navbar-item" href="index.php">Home</a>
      <div class="navbar-item has-dropdown is-hoverable">
          <a class="navbar-link">
            Movies
          </a>

          <div class="navbar-dropdown">
            <a class="navbar-item" href="movies.php">
              All Movies
            </a>
            <a class="navbar-item" href="actors.php">
              All Actors
            </a>
            <a class="navbar-item" href="directors.php">
              All Directors
            </a>
            <a class="navbar-item" href="genre.php">
              All Genre
            </a>
          </div>
        </div>
      <a class="navbar-item" href="movie_add.php">Add Movie</a>
      <a class="navbar-item" href="user_profile.php?uid=<?php echo $_SESSION['userID'] ?>">My Profile</a>
      <a class="navbar-item" href="logout.php">Sign Out</a>
    </div>
  </div>

</nav>
