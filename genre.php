<?php include('inc/header.php');?>
<?php
        if (isset($_SESSION['user'])) {
          require('inc/connection.php');
          require('inc/classmovie.php');
          if (isset($_GET['action'])) {
            if ($_GET['action'] == 'add') {
          if (isset($_POST['addgenre'])) {
            if (!empty($_POST['genreName'])) {
              $genreName = $_POST['genreName'];
              $addGenre = Movie::addGenre($genreName);
              if ($addGenre) {
                echo '<div class="notification is-success">The Genre was Added successfully</div>';
                exit;
              }else {
                echo 'somthing went wrong';
              }

            }else {
              echo 'empty string';
            }
          }else {
            ?>
            <div class="columns is-mobile">
              <div class="column is-half is-offset-one-quarter">
                <br>
                <div class="hero is-light">
                <div class="title">
                  Add new Genre
                </div>
              </div>
            <form class="" action="genre.php?action=add" method="post">
              <div class="field">
                <label class="label">Genre Name</label>
                <div class="control">
                  <input class="input" type="text" name="genreName">
                </div>
              </div>
              <div class="field is-grouped">
                <div class="control">
                  <button class="button is-link" name="addgenre">Add</button>
                </div>
              </div>
            </form>
            </div>
            </div>
            <?php
          }

         }
         if ($_GET['action'] == 'remove') {
           $id = $_GET['id'];
           if(isset($id) && !empty($id) && is_numeric($id)){
           $removeGenre = Movie::deleteGenre($id);
               if (!$removeGenre) {
                 echo '<div class="notification is-waning">this Genre was not found in our DB</div>';
                 exit;
                      }else {
                        echo '<div class="notification is-success">The Genre was removed successfully</div>';
                        exit;
                      }
              }else{
              echo '<div class="notification is-danger">Error: page not found</div>';
              }
              }
              if ($_GET['action'] == 'edit') {
                $id = $_GET['id'];
                if(isset($id) && !empty($id) && is_numeric($id)){
                $getGenreByID = Movie::getGenreByID($id);
                if (!$getGenreByID) {
                  echo '<div class="notification is-warning">this Genre was not found in our DB</div>';
                  exit;
                }
                if (isset($_POST['editGenreform'])) {
                if (!empty($_POST['genreName'])){
                  $GenreName = $_POST['genreName'];
                  $editGenre = Movie::editGenre($id,$GenreName);
                if ($editGenre) {
                  echo '<div class="notification is-success">The Genre was updated successfully</div>';
                  exit;
                }else {
                  echo '<div class="notification is-danger">Somthing went wrong</div>';
                  exit;
                }
                }
                }
                ?>
                <div class="columns is-mobile">
                  <div class="column is-half is-offset-one-quarter">
                    <br>
                    <div class="hero is-light">
                    <div class="title">
                      Edit Actor with id: <?php echo $getGenreByID['GenreID'] ?>
                    </div>
                  </div>
                    <form class="" action="" method="post" enctype="multipart/form-data">
                      <div class="field">
                        <label class="label">Genre Name</label>
                        <div class="control">
                          <input class="input" type="text" value="<?php echo $getGenreByID['GenreName'] ?>" name="genreName">
                        </div>
                      </div>
                      <div class="field is-grouped">
                        <div class="control">
                          <button class="button is-link" name="editGenreform">Save</button>
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
                   echo '<div class="notification is-danger">Error: page not found</div>';
                   }
                 }


       }else {
         $genreList = Movie::getMoviesGenreList();


         ?>
         <div class="column">
             <div class="container">
               <div class="hero is-light">
                 <div class="title">
                   All Genre
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
               <a href="genre.php?action=add" class="button is-success">Add New</a>
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
             if ($genreList == false) {
               echo '<div class="notification is-dark">there is no Data to show</div>';
             }else {
              ?>
              <div class="column">
                <div class="container">
                 <table class="table is-striped is-narrow is-fullwidth">
           <tr>
             <th>ID</th>
             <th>Name</th>
             <th>Movies</th>
             <th>Edit</th>
             <th>Remove</th>
           </tr>
         <?php


         foreach($genreList as $key => $value){
          $countMoviesInGenre = Movie::getMoviesinGenre($value['GenreID']);

           ?>

       <tr>
         <td> <?php echo $value['GenreID']?></td>
         <td><?php echo $value['GenreName']?></td>
         <td> <a href="search.php?filter=<?php echo $value['GenreName']?>"> <?php
         if (!$countMoviesInGenre) {
           echo 'no data';
         }else {
           echo count($countMoviesInGenre);

         }
           ?></a>  </td>
         <td> <a class="tag is-warning" href="genre.php?action=edit&id=<?php echo $value['GenreID']?>">Edit</a></td>
         <td> <a class="tag is-danger" href="genre.php?action=remove&id=<?php echo $value['GenreID']?>">Delete</a></td>
       </tr>

         <?php
         }
           }
     ?>
     </table>


     </div>
     </div>

     <?php
       }

  }else{
    header('Location: login.php');
  }

 ?>
<?php   include('inc/footer.php'); ?>
