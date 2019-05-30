<?php include('inc/header.php');?>
<?php
require('inc/connection.php');
require('inc/classmovie.php');
  if (isset($_SESSION['user'])) {
    if (isset($_POST['addMovieform'])) {
    if (!empty($_POST['movieTitle'])){
      $movieTitle = $_POST['movieTitle'];
      $movieGenre = $_POST['movieGenre'];
      $movieDirector = $_POST['movieDirector'];
      $movieActors = $_POST['movieActors'];
      $movieYear = $_POST['movieYear'];
      $moviePlot = $_POST['moviePlot'];
      $movieLength = $_POST['movieLength'];
      $movieImg = $_FILES['movieimg']['name'];
      $movieTrailer = $_POST['movieTrailer'];

      $imageType = $_FILES['movieimg']['type'];
      $allowed = array("image/jpeg", "image/jpg", "image/png");
      $temp = explode(".", $_FILES["movieimg"]["name"]);
      $target_path = "img/";
      $rename_img =  round(microtime(true)) . '.' . end($temp);
      if(!in_array($imageType, $allowed)) {
        echo '<p class="notification is-danger">Only jpg, png, files are allowed.</p>';
        exit;
      }
      if(move_uploaded_file($_FILES['movieimg']['tmp_name'], $target_path.$rename_img)) {
        $movieImg = $rename_img;
      } else{
          echo '<p class="notification is-danger">There was an error uploading the file, please try again!</p>';
          exit;
      }
      // $inserMovie = Movie::addMovie($movieDirector,$movieTitle,$movieGenre,$movieActors,$movieYear,$moviePlot,$movieLength,$movieImg,$movieTrailer);
      $url = 'http://localhost/php/moviesDB-API/rest/api.php?action=movies&list';
      $data_string = array(
            'MovieTitle'      =>      $movieTitle,
            'MovieGenre'      =>      $movieGenre,
            'MovieDirector'   =>      $movieDirector,
            'MovieActors'     =>      $movieActors,
            'MovieYear'       =>      $movieYear,
            'MoviePlot'       =>      $moviePlot,
            'MovieLength'     =>      $movieLength,
            'MovieImg'        =>      $movieImg,
            'MovieTrailer'    =>      $movieTrailer
      );
      $data_string = json_encode($data_string);

      // var_dump ($data_string);
      $letsSAveMovie = addMovie($url, $data_string);
      var_dump($letsSAveMovie);
      if (!$letsSAveMovie) {
        echo 'faild';
        exit;
      }

      echo '<p class="notification is-success">The Movie has been successfully added</p>';

    }else {
      echo '<p class="notification is-warning">all fields are required</p>';
    }
  }
    $getGenre = Movie::getMoviesGenreList();
    $getDirector = Movie::getMoviesDirectorList();
    $getActors = Movie::getMoviesActorsList();
    ?>
    <div class="columns is-mobile">
      <div class="column is-half is-offset-one-quarter">
        <br>
        <div class="hero is-light">
        <div class="title">
          Add New Movie
        </div>
      </div>
    <form class="" action="" method="post" enctype="multipart/form-data">
      <div class="field">
        <label class="label">Title</label>
        <div class="control">
          <input class="input" type="text" name="movieTitle">
        </div>
      </div>

      <div class="field">
      <label class="label">Select Genre</label>
      <div class="control">
          <select  id="genre" name="movieGenre[]" multiple="multiple">
            <?php
            foreach ($getGenre as $key => $value) {
              echo '<option value="'. $value['GenreID'].'">' . $value['GenreName'].'</option>';
            }
            ?>
          </select>
          <a href="genre.php?action=add">Add New Genre</a>
      </div>
    </div>
    <br>
    <div class="field">
    <label class="label">Select Director</label>
    <div class="control">
        <select  id="director" name="movieDirector">
          <?php
          foreach ($getDirector as $key => $value) {
            // code...
            echo '<option value="'. $value['DirectorID'].'">' . $value['DirectorFirstName']. ' '.$value['DirectorLastName'].'</option>';
          }
          ?>
        </select>
        <a href="directors.php?action=add">Add New Director</a>
    </div>
  </div>
  <div class="field">
  <label class="label">Select Actors</label>
  <div class="control">
      <select  id="actors" name="movieActors[]" multiple="multiple">
        <?php
        foreach ($getActors as $key => $value) {
          // code...
          echo '<option value="'. $value['ActorID'].'">' . $value['ActorFirstName']. ' '.$value['ActorLastName'].'</option>';
        }

        ?>
      </select>
      <a href="actors.php?action=add">Add New Actor</a>
  </div>
</div>
<div class="field">
  <label class="label">Release Year</label>
  <div class="control">
  <input class="input" id="date" type="date" name="movieYear">
  </div>
</div>
<div class="field">
  <label class="label">Plot</label>
  <div class="control">
    <input class="input" type="text" name="moviePlot">
  </div>
</div>
<div class="field">
  <label class="label">Length</label>
  <div class="control">
    <input class="input" type="text" name="movieLength">
  </div>
</div>
<div class="field">
  <label class="label">Image</label>
  <div class="control">
    <input class="input" type="file" name="movieimg">
  </div>
</div>
<div class="field">
  <label class="label">Trailer</label>
  <div class="control">
    <input class="input" type="text" name="movieTrailer">
  </div>
</div>
<div class="field is-grouped">
  <div class="control">
    <button class="button is-link" name="addMovieform">Add</button>
  </div>
  <div class="control">
    <button class="button is-text">Cancel</button>
  </div>
</div>
    </form>
    </div>
    </div>
    <?php

  }else{
    header('Location: login.php');
  }


 ?>
<?php   include('inc/footer.php'); ?>
