<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset=UTF-8");
require("../inc/connection.php");
require("../inc/functions.php");
require("../inc/classmovie.php");
if (isset($_GET['action'])) {
if ($_GET['action'] == 'movies') {
  //read only one movie by id
if(isset($_GET['movie_id']) && $_GET['movie_id'] > 0 ){
    $movieData = getMovieByID($_GET['movie_id']);
    $output = $movieData;

    echo json_encode($output);
}
//read all movies
if(isset($_GET['list'])){
    $movieList = listMovies();
    $output = $movieList;

    echo json_encode($output);
}

}else {
  echo 'action not found';
}
}else {
  echo 'page not found';
}
?>
