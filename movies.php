<?php include('inc/header.php');?>

<?php
  if (isset($_SESSION['user'])) {
    require('inc/connection.php');
    require('inc/classmovie.php');
    $movie = Movie::display_data();

    ?>

              <div class="column">
                  <div class="container">
                    <div class="hero is-light">
                      <div class="title">
                        All Movies
                      </div>
                    </div>
                  </div>
              </div>
        <div class="column">
          <div class="container">
          <nav class="level">
              <!-- Left side -->
              <div class="level-left">
                <div class="level-item">
                    <a href="movie_add.php" class="button is-success">Add New</a>
                </div>
              </div>

              <!-- Right side -->
              <div class="level-right">
                <div class="level-item">
                  <form class="" action="search.php" method="GET">
                  <div class="field has-addons">
                  <div class="control">
                    <input class="input" type="text" name="query">
                  </div>
                  <div class="control">
                    <button class="button is-light" name="">Search</button>
                  </div>
                </div>
              </form>
            </div>
              </div>
            </nav>
        </div>
        </div>
        <?php
        if ($movie == false) {
          echo '<div class="notification is-dark">there is no Movies to show</div>';
        }else {
         ?>
    <div class="column">
      <div class="container">


       <table class="table is-striped is-narrow is-fullwidth">
      <tr>
        <th>Image</th>
        <th>Title</th>
        <th>Release Date</th>
        <th>Director</th>
        <th>View</th>
        <th>Edit</th>
        <th>Remove</th>
      </tr>
    <?php



    foreach($movie as $key => $value){

      ?>

  <tr>
    <td>
      <figure class="image is-square">
      <img src="img/<?php echo $value->MovieImg ?>" alt="<?php echo $value->MovieTitle?>">
    </figure>
    </td>
    <td><?php echo $value->MovieTitle?></td>
    <td><?php echo $value->MovieYear?></td>
    <td> <a href="directors.php?action=view&id=<?php echo $value->DirectorID?>"> <?php echo $value->DirectorFirstName.' '.$value->DirectorLastName ?></a></td>
    <td> <a class="tag is-info" href="movie_page.php?id=<?php echo $value->MovieID?>">View</a></td>
    <td> <a class="tag is-warning" href="movie_edit.php?id=<?php echo $value->MovieID?>">Edit</a></td>
    <td> <a class="tag is-danger" href="movie_delete.php?id=<?php echo $value->MovieID?>">Delete</a></td>
  </tr>

    <?php
    }
      }
?>
</table>
</div>
      </div>


<?php
  }else{
    header('Location: login.php');
  }


 ?>
<?php   include('inc/footer.php'); ?>
