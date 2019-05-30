<?php include('inc/header.php');?>
<?php
if (isset($_SESSION['user'])) {
  include('inc/connection.php');
  include('inc/classmovie.php');
if ((isset($_GET['id'])) && (!empty($_GET['id'])) && (is_numeric($_GET['id']))){
                          $id = $_GET['id'];
                          $movieID = Movie::getMovieByID($id);
                          // $moviesGenre[] = $movieGenra;
                          // $genreItems = Movie::getMovieGenre($id);
                          // $actorsItems = Movie::getMovieActors($id);

                          if ($movieID) {
                            ?>
                            <div class="column">
                            </div>
                            <div class="column">
                                <div class="container">
                                  <div class="hero is-light">
                                    <div class="title">
                                      <?php echo $movieID->MovieTitle ?> (<?php echo date("Y",strtotime($movieID->MovieYear))  ?>)
                                    </div>
                                  </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="container">
                                    <figure class="image is-3by1">
                                      <img src="img/<?php echo $movieID->MovieImg ?>" alt="  <?php echo $movieID->MovieTitle ?>">
                                    </figure>
                                </div>
                            </div>
                            <div class="column">
                                <div class="container">
                                    <p class="">
                                      <?php echo $movieID->MoviePlot ?>
                                    </p>
                                </div>
                            </div>
                            <div class="column">
                                <div class="container">
                                  <div class="tags has-addons">
                                    <span class="tag is-primary">Release Year</span>
                                    <span class="tag"><?php echo $movieID->MovieYear ?></span>
                                  </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="container">
                                  <div class="tags has-addons">
                                    <span class="tag is-primary">Length</span>
                                    <span class="tag"><span> <?php echo $movieID->MovieLength ?>min</span></span>
                                  </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="container">
                                  <div class="tags has-addons">
                                    <span class="tag is-primary">Director</span>
                                    <span class="tag">
                                      <a href="directors.php?action=view&id=<?php  echo $movieID->DirectorID ?>"> <?php echo $movieID->DirectorFirstName.' ' . $movieID->DirectorLastName ?></a>
                                    </span>
                                  </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="container">
                                  <p class="tag is-primary">Genre</p>
                                  <br>
                                  <div class="tags">
                                    <?php
                                    foreach($movieID->genre as $val) {
                                      echo '<span class="tag">';
                                        echo '<a href="genre.php?GenreID='.$val->GenreID.'">'. $val->genreName.'</a>';
                                      echo '</span>';
                                        }
                                     ?>
                                </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="container">
                                  <p class="tag is-primary">Stars</p>
                                  <div class="tags">
                                    <?php
                                    foreach($movieID->actors as $val) {
                                      echo '<span class="tag">';
                                      echo '<a href="actors.php?action=view&id='.$val->ActorID.'">' . $val->ActorFirstName.' '.$val->ActorLastName.'</a>';
                                      echo '</span>';
                                        }
                                     ?>
                                </div>
                                </div>
                            </div>
                            <div class="column">
                              <div class="container">
                              <iframe width="100%" height="auto" src="<?php echo $movieID->MovieTrailer ?>" frameborder="0" allowfullscreen></iframe>
                              </div>
                            </div>

                            <?php
                          }else {
                            echo 'Movie With this ID not found in DB';
                          }
                      }else {
                        echo "Page not found Data Error";
                      }
  }else{
    header('Location: login.php');
  }


 ?>
<?php   include('inc/footer.php'); ?>
