<?php include('inc/header.php');?>
<?php
  if (isset($_SESSION['user'])) {

    if ((isset($_GET['query'])) && (!empty($_GET['query']))){
      require_once("inc/connection.php");
     $search = $_GET['query'];
     $output = NULL;
             if( isset($search) && !empty($search)) {
                 $search = htmlspecialchars($search);

                 $sql = "SELECT * FROM movies

                  WHERE MovieTitle LIKE '%".$search."%'" ;

                 $result = mysqli_query($db, $sql);
                         if (mysqli_num_rows($result) > 0) {
                           ?>
                           <div class="columns is-mobile">
                             <?php
                             $searchList = array();
                             while($row = mysqli_fetch_assoc($result)) {
                               $searchList[] = $row;
                      foreach ($searchList as $item){
                      ?>
                      <div class="column is-one-fifth">
                      <section class="section">
                        <div class="card">
                        <div class="card-image">
                          <figure class="image is-4by3">
                            <img src="img/<?php echo $item['MovieImg'] ?>" alt="img/<?php echo $item['Movietitle'] ?>">
                          </figure>
                        </div>
                        <div class="card-content">
                          <div class="media">
                            <div class="media-content">
                              <p class="title is-4"><a href="movie_page.php?id=<?php echo $item['MovieID'] ?>"><?php echo $item['MovieTitle'] ?> (<?php echo date("Y",strtotime($item['MovieYear']))  ?>) </a> </p>
                            </div>
                          </div>
                        </div>
                      </div>
                      </section>
                      </div>
                      <?php
                      }
                             }

                             ?></div><?php
                 }else{
                     echo '<div class="notification is-info">No movie found: <strong>'. $search .'</strong></div>';
                 }
                 }
         }else{
         echo '<div class="notification is-danger">Empty input</div>';
         }
  }else{
    header('Location: login.php');
  }


 ?>
<?php   include('inc/footer.php'); ?>
