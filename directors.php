<?php include('inc/header.php');?>
<?php
        if (isset($_SESSION['user'])) {
          require('inc/connection.php');
          require('inc/classmovie.php');
          if (isset($_GET['action'])) {
            if ($_GET['action'] == 'add') {
          if (isset($_POST['adddirector'])) {
            if (!empty($_POST['dFirstName']) && !empty($_POST['dLastName']) && !empty($_POST['dBirthday'])) {
              $directorFirstName = $_POST['dFirstName'];
              $directorLastName = $_POST['dLastName'];
              $directorBirthday = $_POST['dBirthday'];
              $addDirector = Movie::addDirector($directorFirstName,$directorLastName,$directorBirthday);
              if ($addDirector) {
                echo '<div class="notification is-success">Director was added successfully</div>';
                exit;
              }else {
                echo '<div class="notification is-danger">somthing went wrong</div>';
                exit;
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
                  Add new Director
                </div>
              </div>
            <form class="" action="directors.php?action=add" method="post">
              <div class="field">
                <label class="label">Director First Name</label>
                <div class="control">
                  <input class="input" type="text" name="dFirstName">
                </div>
              </div>
              <div class="field">
                <label class="label">Director Last Name</label>
                <div class="control">
                  <input class="input" type="text" name="dLastName">
                </div>
              </div>
              <div class="field">
                <label class="label">Birthday</label>
                <div class="control">
                <input class="input" id="date" type="date" name="dBirthday">
                </div>
              </div>
              <div class="field is-grouped">
                <div class="control">
                  <button class="button is-link" name="adddirector">Add</button>
                </div>
              </div>
            </form>
            </div>
            </div>
            <?php
          }
 }
 if ($_GET['action'] == 'edit') {
   $id = $_GET['id'];
   if(isset($id) && !empty($id) && is_numeric($id)){
   $getDirectorByID = Movie::getDirectorByID($id);
   if (!$getDirectorByID) {
     echo '<div class="notification is-warning">this Director was not found in our DB</div>';
     exit;
   }
   if (isset($_POST['editDirectorform'])) {
   if (!empty($_POST['directorFirstName']) && !empty($_POST['directorLastName']) && !empty($_POST['directorBirthday'])){
     $directorFirstName = $_POST['directorFirstName'];
     $directorLastName = $_POST['directorLastName'];
     $directorBirthday = $_POST['directorBirthday'];
     $editDirector = Movie::editDirector($id,$directorFirstName,$directorLastName,$directorBirthday);
   if ($editDirector) {
     echo '<div class="notification is-success">The director was updated successfully</div>';
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
         Edit Director with id: <?php echo $getDirectorByID['DirectorID'] ?>
       </div>
     </div>
   <form class="" action="" method="post" enctype="multipart/form-data">
     <div class="field">
       <label class="label">First Name</label>
       <div class="control">
         <input class="input" type="text" value="<?php echo $getDirectorByID['DirectorFirstName'] ?>" name="directorFirstName">
       </div>
     </div>
     <div class="field">
       <label class="label">Last Name</label>
       <div class="control">
         <input class="input" type="text" value="<?php echo $getDirectorByID['DirectorLastName'] ?>" name="directorLastName">
       </div>
     </div>
     <div class="field">
       <label class="label">Birthday</label>
       <div class="control">
           <input class="input" id="date" type="date" value="<?php echo $getDirectorByID['DirectorBirthday'] ?>" name="directorBirthday">
       </div>
     </div>
     <div class="field is-grouped">
       <div class="control">
         <button class="button is-link" name="editDirectorform">Save</button>
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




if ($_GET['action'] == 'remove') {
  $id = $_GET['id'];
  if(isset($id) && !empty($id) && is_numeric($id)){
  $removeDirector = Movie::deleteDirector($id);
      if (!$removeDirector) {
        echo '<div class="notification is-waning">this Director was not found in our DB</div>';
        exit;
      }else {
        echo '<div class="notification is-success">The Director was removed successfully</div>';
        exit;
      }
     }else{
     echo '<div class="notification is-danger">Error: page not found</div>';
     }
     }
        if ($_GET['action'] == 'view') {
        $id = $_GET['id'];
        if (isset($id) && !empty($id) && is_numeric($id)) {
          $getDirectorID = Movie::getDirectorByID($id);
          $getDirectorMovies = Movie::getDirectorMovies($id);
          if (!$getDirectorID) {
            echo '<div class="notification is-warning">this director was not found in our DB</div>';
            exit;
          }
    ?>
              <div class="columns is-mobile">
                  <div class="column is-half is-offset-one-quarter">
                    <br>
                    <div class="level">
                      <div class="level-left">
                        <div class="level-item">
                          <div class="title">
                            Director with id:
                            <?php echo $getDirectorID['DirectorID'] ?>
                          </div>
                      </div>
                      </div>
                      <div class="level-right">
                        <div class="level-item">
                        <div class="tags">
                          <a class="tag is-info" href="directors.php?action=edit&id=<?php echo $getDirectorID['DirectorID'] ?>">Edit</a>
                          <a class="tag is-danger" href="directors.php?action=remove&id=<?php echo $getDirectorID['DirectorID'] ?>">Remove</a>
                        </div>
                        </div>
                      </div>
                    </div>
                    <br>
                    <br>
                    <section>
                      <p class="subtitle"> <strong>Full Name: </strong> <?php echo $getDirectorID['DirectorFirstName'] .' '.$getDirectorID['DirectorLastName']; ?></p>
                      <p class="subtitle"> <strong>Birthday: </strong> <?php echo $getDirectorID['DirectorBirthday']; ?></p>
                      <p class="subtitle"> <strong>Movies: </strong></p>
                      <br>
                    </section>
                    <?php
                    echo '<div class="columns">';
                    if (!$getDirectorMovies) {
                      echo '<div class="notification is-dark">no data for this ID</div>';
                      exit;
                    }
                    foreach ($getDirectorMovies as $key => $value) {
                     ?>
                    <div class="column  is-two-fifth">
                    <section class="section">
                      <div class="card">
                      <div class="card-image">
                        <figure class="image is-4by3">
                          <img src="img/<?php echo $value['MovieImg'] ?>" alt="img/<?php echo $value['Movietitle'] ?>">
                        </figure>
                      </div>
                      <div class="card-content">
                        <div class="media">
                          <div class="media-content">
                            <p class="title is-4"><a href="movie_page.php?id=<?php echo $value['MovieID'] ?>"><?php echo $value['MovieTitle'] ?> (<?php echo date("Y",strtotime($value['MovieYear']))  ?>) </a> </p>
                          </div>
                        </div>
                      </div>
                    </div>
                    </section>

                  </div>
                  <?php
    }
                   ?>
                   </div>
                  </div>
              </div>
    <?php
  }else{
    echo '<div class="notification is-danger">Error: Page not found</div>';
    }
                   }
         }else {
           $directorsList = Movie::getMoviesDirectorList();


           ?>
           <div class="column">
               <div class="container">
                 <div class="hero is-light">
                   <div class="title">
                     All Directors
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
                 <a href="directors.php?action=add" class="button is-success">Add New</a>
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
               if ($directorsList == false) {
                 echo '<div class="notification is-dark">there is no Data to show</div>';
               }else {
                ?>
                <div class="column">
                  <div class="container">
                   <table class="table is-striped is-narrow is-fullwidth">
             <tr>
               <th>ID</th>
               <th>Name</th>
               <th>Birthday</th>
               <th>Movies</th>
               <th>View</th>
               <th>Edit</th>
               <th>Remove</th>
             </tr>
           <?php


           foreach($directorsList as $key => $value){
            $countDirectorsMovies = Movie::getDirectorMovies($value['DirectorID']);

             ?>

         <tr>
           <td> <?php echo $value['DirectorID']?></td>
           <td><?php echo $value['DirectorFirstName'] . ' '. $value['DirectorLastName'] ?></td>
           <td><?php echo $value['DirectorBirthday']?></td>
           <td> <a href="directors.php?action=view&id=<?php echo $value['DirectorID']?>"> <?php
           if (!$countDirectorsMovies) {
             echo 'no data';
           }else {
             echo count($countDirectorsMovies);
           }
             ?></a>  </td>
           <td> <a class="tag is-info" href="directors.php?action=view&id=<?php echo $value['DirectorID']?>">View</a></td>
           <td> <a class="tag is-warning" href="directors.php?action=edit&id=<?php echo $value['DirectorID']?>">Edit</a></td>
           <td> <a class="tag is-danger" href="directors.php?action=remove&id=<?php echo $value['DirectorID']?>">Delete</a></td>
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
