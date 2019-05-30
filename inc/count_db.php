<?php
if (!isset($_SESSION['user'])) {
  echo 'You need to sign in first';
}
$getMovies = Movie::display_data();
$getGenre = Movie::getMoviesGenreList();
$getDirectors = Movie::getMoviesDirectorList();
$getActors = Movie::getMoviesActorsList();
if ($getMovies && $getGenre && $getDirectors && $getActors) {
  // code...

 ?>
  <nav class="level">
    <div class="level-item has-text-centered">
      <div>
        <p class="heading">Movies</p>
        <p class="title"><?php echo count($getMovies) ?></p>
      </div>
    </div>
    <div class="level-item has-text-centered">
      <div>
        <p class="heading">Actors</p>
        <p class="title"><?php echo count($getActors) ?></p>
      </div>
    </div>
    <div class="level-item has-text-centered">
      <div>
        <p class="heading">Directors</p>
        <p class="title"><?php echo count($getDirectors) ?></p>
      </div>
    </div>
    <div class="level-item has-text-centered">
      <div>
        <p class="heading">Genre</p>
        <p class="title"><?php echo count($getGenre) ?></p>
      </div>
    </div>
  </nav>
<?php
}else {
  echo '<div class="notification is-black">No data</div>';
}
 ?>
