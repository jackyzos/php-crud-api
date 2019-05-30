<?php include('inc/header.php');
    if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
      require('inc/connection.php');
      require('inc/classmovie.php');
      echo '<div class="container">';
      include('inc/count_db.php');
      $newAddedMovie = Movie::getNewAddedMovies();
      $getActorsList = Movie::getMoviesActorsList();
      $getDirectorsList = Movie::getMoviesDirectorList();
    ?>
    <div class="tile is-ancestor">
      <div class="tile is-parent">
        <div class="tile is-child">
          <div class="hero is-light">
            <div class="title">
              Recently Added
            </div>
          </div>
          <br>
          <div class="columns">
      <?php
      if ($newAddedMovie) {
      foreach ($newAddedMovie as $key => $value) {
       ?>
       <div class="column is-one-third">
          <div class="box">
                  <figure class="image is-square">
                    <img src="img/<?php echo $value['MovieImg'] ?>" alt="<?php echo $value['MovieTitle'] ?>">
                  </figure>

                <hr class="navbar-divider">
                   <div class="title" style="text-align: center;">
                  <a href="movie_page.php?id=<?php echo $value['MovieID'] ?>"><?php echo $value['MovieTitle'] ?> (<?php echo date("Y",strtotime($value['MovieYear']))  ?>)</a>
                   </div>
              </div>
            </div>
      <?php
      }
    }else {
      echo 'no data';
    }
       ?>
     </div>
     </div>
     </div>
  <div class="tile is-4 is-vertical is-parent">
    <div class="tile is-child">
      <div class="hero is-light">
        <div class="title">
          Actors
        </div>
      </div>
      <br>
      <table class="table is-fullwidth is-striped">
         <tr>
           <th>Actor</th>
           <th>Born in</th>
         </tr>
         <?php
         if ($getActorsList) {
         foreach ($getActorsList as $key => $value) {
          ?>
          <tr>
            <td><?php echo $value['ActorFirstName'].' '. $value['ActorLastName'] ?></td>
            <td><?php echo $value['ActorBirthday'] ?></td>
          </tr>
          <?php
         }
       }else {
         echo 'no data';
       }
          ?>
      </table>
    </div>
    <div class="tile is-child">
      <div class="hero is-light">
        <div class="title">
          Directors
        </div>
      </div>
      <br>
      <table class="table is-fullwidth is-striped">
         <tr>
           <th>Directors</th>
           <th>Born in</th>
         </tr>
         <?php
         if ($getDirectorsList) {
         foreach ($getDirectorsList as $key => $value) {
          ?>
          <tr>
            <td><?php echo $value['DirectorFirstName'].' '. $value['DirectorLastName'] ?></td>
            <td><?php echo $value['DirectorBirthday'] ?></td>
          </tr>
          <?php
         }
      }else {
        echo 'no data';
      }
          ?>
      </table>
    </div>
  </div>
</div>
    </div>
    <?php
    }else{
      header('Location: login.php');
  }
?>
<?php   include('inc/footer.php'); ?>
