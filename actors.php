<?php include('inc/header.php');?>
<?php
        if (isset($_SESSION['user'])) {
          require('inc/connection.php');
          require('inc/classmovie.php');
          if (isset($_GET['action'])) {
            if ($_GET['action'] == 'add') {
          if (isset($_POST['addactor'])) {
            if (!empty($_POST['aFirstName']) && !empty($_POST['aLastName']) && !empty($_POST['aBirthday'])) {
              $actorFirstName = $_POST['aFirstName'];
              $actorLastName = $_POST['aLastName'];
              $actorBirthday = $_POST['aBirthday'];
              $addactor = Movie::addactor($actorFirstName,$actorLastName,$actorBirthday);
              if ($addactor) {
                echo '<div class="notification is-success">actor was added successfully</div>';
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
                  Add new Actor
                </div>
              </div>
            <form class="" action="actors.php?action=add" method="post">
              <div class="field">
                <label class="label">Actor First Name</label>
                <div class="control">
                  <input class="input" type="text" name="aFirstName">
                </div>
              </div>
              <div class="field">
                <label class="label">Actor Last Name</label>
                <div class="control">
                  <input class="input" type="text" name="aLastName">
                </div>
              </div>
              <div class="field">
                <label class="label">Birthday</label>
                <div class="control">
                <input class="input" id="date" type="date" name="aBirthday">
                </div>
              </div>
              <div class="field is-grouped">
                <div class="control">
                  <button class="button is-link" name="addactor">Add</button>
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
        $getActorByID = Movie::getActorByID($id);
        if (!$getActorByID) {
          echo '<div class="notification is-warning">this Actor was not found in our DB</div>';
          exit;
        }
        if (isset($_POST['editActorform'])) {
        if (!empty($_POST['actorFirstName']) && !empty($_POST['actorLastName']) && !empty($_POST['actorBirthday'])){
          $actorFirstName = $_POST['actorFirstName'];
          $actorLastName = $_POST['actorLastName'];
          $actorBirthday = $_POST['actorBirthday'];
          $editActor = Movie::editActor($id,$actorFirstName,$actorLastName,$actorBirthday);
        if ($editActor) {
          echo '<div class="notification is-success">The actor was updated successfully</div>';
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
              Edit Actor with id: <?php echo $getActorByID['ActorID'] ?>
            </div>
          </div>
        <form class="" action="" method="post" enctype="multipart/form-data">
          <div class="field">
            <label class="label">First Name</label>
            <div class="control">
              <input class="input" type="text" value="<?php echo $getActorByID['ActorFirstName'] ?>" name="actorFirstName">
            </div>
          </div>
          <div class="field">
            <label class="label">Last Name</label>
            <div class="control">
              <input class="input" type="text" value="<?php echo $getActorByID['ActorLastName'] ?>" name="actorLastName">
            </div>
          </div>
          <div class="field">
            <label class="label">Birthday</label>
            <div class="control">
                <input class="input" id="date" type="date" value="<?php echo $getActorByID['ActorBirthday'] ?>" name="actorBirthday">
            </div>
          </div>
          <div class="field is-grouped">
            <div class="control">
              <button class="button is-link" name="editActorform">Save</button>
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
       $removeActor = Movie::deleteActor($id);
           if (!$removeActor) {
             echo '<div class="notification is-waning">this Actor was not found in our DB</div>';
             exit;
                  }else {
                    echo '<div class="notification is-success">The Actor was removed successfully</div>';
                    exit;
                  }
          }else{
          echo '<div class="notification is-danger">Error: page not found</div>';
          }
          }
    if ($_GET['action'] == 'view') {
		$id = $_GET['id'];
    if (isset($id) && !empty($id) && is_numeric($id)) {
    $getActorID = Movie::getActorByID($id);
    $getActorMovies = Movie::getActorMovies($id);
    if (!$getActorID) {
      echo '<div class="notification is-warning">this Actor was not found in our DB</div>';
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
                    Actor with id:
                    <?php echo $getActorID['ActorID'] ?>
                  </div>
                  </div>
                  </div>
                  <div class="level-right">
                    <div class="level-item">
                    <div class="tags">
                      <a class="tag is-info" href="actors.php?action=edit&id=<?php echo $getActorID['ActorID'] ?>">Edit</a>
                      <a class="tag is-danger" href="actors.php?action=remove&id=<?php echo $getActorID['ActorID'] ?>">Remove</a>
                    </div>
                    </div>
                  </div>
                </div>
                <br>
                <section>
                  <p class="subtitle"> <strong>Full Name: </strong> <?php echo $getActorID['ActorFirstName'] .' '.$getActorID['ActorLastName']; ?></p>
                  <p class="subtitle"> <strong>Birthday: </strong> <?php echo $getActorID['ActorBirthday']; ?></p>
                  <p class="subtitle"> <strong>Movies: </strong></p>
                    <br>
                </section>
                <?php
                echo '<div class="columns">';
                if (!$getActorMovies) {
                  echo '<div class="notification is-dark">no data for this ID</div>';
                  exit;
                }
                foreach ($getActorMovies as $key => $value) {
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
          echo '<div class="notification is-danger">Error: page not found</div>';
          }
       }
         }else {
           $actorsList = Movie::getMoviesActorsList();


           ?>
           <div class="column">
               <div class="container">
                 <div class="hero is-light">
                   <div class="title">
                     All Actors
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
                 <a href="actors.php?action=add" class="button is-success">Add New</a>
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
               if ($actorsList == false) {
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


           foreach($actorsList as $key => $value){
            $countActorsMovies = Movie::getActorMovies($value['ActorID']);

             ?>

         <tr>
           <td> <?php echo $value['ActorID']?></td>
           <td><?php echo $value['ActorFirstName'] . ' '. $value['ActorLastName'] ?></td>
           <td><?php echo $value['ActorBirthday']?></td>
           <td> <a href="actors.php?action=view&id=<?php echo $value['ActorID']?>"> <?php
           if (!$countActorsMovies) {
             echo 'no data';
           }else {
             echo count($countActorsMovies);
           }
             ?></a>  </td>
           <td> <a class="tag is-info" href="actors.php?action=view&id=<?php echo $value['ActorID']?>">View</a></td>
           <td> <a class="tag is-warning" href="actors.php?action=edit&id=<?php echo $value['ActorID']?>">Edit</a></td>
           <td> <a class="tag is-danger" href="actors.php?action=remove&id=<?php echo $value['ActorID']?>">Delete</a></td>
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
