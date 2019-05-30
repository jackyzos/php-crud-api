<?php include('inc/header.php');?>
<?php
require('inc/connection.php');
require('inc/classmovie.php');
  if (isset($_SESSION['user'])) {
        $id = $_GET['id'];
    if (isset($_POST['editMovieform'])) {
    if (!empty($_POST['movieTitle']) && !empty($_POST['movieGenre']) && !empty($_POST['movieDirector']) && !empty($_POST['moviePlot']) && !empty($_POST['movieTrailer'])){
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
      $url = "http://localhost/php/moviesDB-API/rest/api.php?action=movies&movie_id=$id";
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
      $letsSAveMovie = updateMovie($id,$url, $data_string);
      var_dump($letsSAveMovie);
      if (!$letsSAveMovie) {
        echo 'faild';
        exit;
      }
      echo '<p class="notification is-success">The Movie has been successfully Updated</p>';
    }else {
      echo '<p class="notification is-warning">all fields are required</p>';
    }
  }
    $movieID = Movie::getMovieByID($id);
    $genreItems = Movie::getMovieGenre($id);
    $actorsItems = Movie::getMovieActors($id);

    $getGenre = Movie::getMoviesGenreList();
    $getDirector = Movie::getMoviesDirectorList();
    $getActors = Movie::getMoviesActorsList();
    ?>
    <div class="columns is-mobile">
      <div class="column is-half is-offset-one-quarter">
        <br>
        <div class="hero is-light">
        <div class="title">
          Edit Movie with id: <?php echo $movieID->MovieID ?>
        </div>
      </div>
    <form class="" action="" method="post" enctype="multipart/form-data">
      <div class="field">
        <label class="label">Title</label>
        <div class="control">
          <input class="input" type="text" value="<?php echo $movieID->MovieTitle ?>" name="movieTitle">
        </div>
      </div>

      <div class="field">
      <label class="label">Select Genre</label>
      <div class="control">
        <?php
        // var_dump($movieID);
        // $result = array_intersect($genreItems,$getGenre);
        // var_dump($result);
        echo '<div class="tags">';
        // foreach ($genreItems as $k => $v) {
        //
        //     echo '<div class="tag" value="'. $value['GenreID'].'">' . $value['GenreName'].'</div>';
        // }
        echo '</div>';

        ?>
          <select  id="genre" name="movieGenre[]" multiple="multiple">
            <?php
            foreach ($genreItems as $key => $value) {
                echo '<option value="'. $value['GenreID'].'"  selected="selected">' . $value['GenreName'].'</option>';
              }

              foreach ($getGenre as $k => $v) {
                  echo '<option value="'. $v['GenreID'].'">' . $v['GenreName'].'</option>';
            }
            ?>
          </select>
          <a href="genre_add.php">Add New Genre</a>
      </div>
    </div>
    <br>
    <div class="field">
    <label class="label">Select Director</label>
    <div class="control">
        <select  id="director" name="movieDirector">
          <?php
          echo '<option value="'. $movieID->DirectorID.'" selected="selected">' . $movieID->DirectorFirstName. ' '.$movieID->DirectorLastName.'</option>';
          foreach ($getDirector as $key => $value) {
            echo '<option value="'. $value['DirectorID'].'">' . $value['DirectorFirstName']. ' '.$value['DirectorLastName'].'</option>';
          }
          ?>
        </select>
        <a href="genre_add.php">Add New Director</a>
    </div>
  </div>
  <div class="field">
  <label class="label">Select Actors</label>
  <div class="control">
      <select  id="actors" name="movieActors[]" multiple="multiple">
        <?php
        foreach ($actorsItems as $key => $value) {
            echo '<option value="'. $value['ActorID'].'" selected="select">' . $value['ActorFirstName']. ' '.$value['ActorLastName'].'</option>';
          }
          foreach ($getActors as $k => $v) {
            echo '<option value="'. $v['ActorID'].'">' . $v['ActorFirstName']. ' '.$v['ActorLastName'].'</option>';
        }
        ?>

      </select>
      <a href="genre_add.php">Add New Actor</a>
  </div>
</div>
<div class="field">
  <label class="label">Release Year</label>
  <div class="control">
  <input class="input" id="date" type="date" value="<?php echo $movieID->MovieYear ?>" name="movieYear">
  </div>
</div>
<div class="field">
  <label class="label">Plot</label>
  <div class="control">
    <input class="input" type="text" value="<?php echo $movieID->MoviePlot ?>" name="moviePlot">
  </div>
</div>
<div class="field">
  <label class="label">Length</label>
  <div class="control">
    <input class="input" type="text" value="<?php echo $movieID->MovieLength ?>" name="movieLength">
  </div>
</div>
<div class="field">
  <label class="label">Image</label>
  <div class="control">
    <input class="input" type="file" value="<?php echo $movieID->MovieImg ?>" name="movieimg">
  </div>
</div>
<div class="field">
  <label class="label">Trailer</label>
  <div class="control">
    <input class="input" type="text" value="<?php echo $movieID->MovieTrailer ?>" name="movieTrailer">
  </div>
</div>
<div class="field is-grouped">
  <div class="control">
    <button class="button is-link" name="editMovieform">Save</button>
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
