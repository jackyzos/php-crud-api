<?php
function addMovie($url, $jsonString){
$ch = curl_init();
$timeout = 0; // Set 0 for no timeout.
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonString);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($jsonString))
);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

$result = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if($status == 200){
  curl_close($ch);
  $data = json_decode($jsonString);
    // lets save to database
  $movieTitle = $data->MovieTitle;
  $movieGenre = $data->MovieGenre;
  $movieDirector = $data->MovieDirector;
  $movieActors = $data->MovieActors;
  $movieYear = $data->MovieYear;
  $moviePlot = $data->MoviePlot;
  $movieLength = $data->MovieLength;
  $movieImg = $data->MovieImg;
  $movieTrailer = $data->MovieTrailer;

  $saveToDb = Movie::addMovie($movieDirector,$movieTitle,$movieGenre,$movieActors,$movieYear,$moviePlot,$movieLength,$movieImg,$movieTrailer);
   return $data;
}
return false;

}
function updateMovie($id, $url, $jsonString){
$ch = curl_init();
$timeout = 0; // Set 0 for no timeout.
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonString);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($jsonString))
);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

$result = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if($status == 200){
  curl_close($ch);
  $data = json_decode($jsonString);
    // lets save to database
  $movieTitle = $data->MovieTitle;
  $movieGenre = $data->MovieGenre;
  $movieDirector = $data->MovieDirector;
  $movieActors = $data->MovieActors;
  $movieYear = $data->MovieYear;
  $moviePlot = $data->MoviePlot;
  $movieLength = $data->MovieLength;
  $movieImg = $data->MovieImg;
  $movieTrailer = $data->MovieTrailer;

  $updateToDb = Movie::updateMovie($id,$movieDirector,$movieTitle,$movieGenre,$movieActors,$movieYear,$moviePlot,$movieLength,$movieImg,$movieTrailer);
   return $data;
}
return false;

}
// function för att radera en film via cUrl
function deleteMovie($id, $url){
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
$result = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if($status == 200){
  curl_close($ch);
    $deleteFromDb = Movie::deleteMovie($id);
   return true;
}
return false;

}
// function som hämtar data från databasen some tilldelas sen i api.php
function listMovies(){
  global $db;
  $sql ="SELECT * FROM movies JOIN directors
        ON movies.DirectorID = directors.DirectorID ";
  $result = $db->query($sql);
  $getGenre = array();
  $getActors = array();
  if(!empty($result) && $result->num_rows > 0){
    $array =  array();
while ($row = $result->fetch_assoc()) {
  $getGenre = getMovieGenre($row['MovieID']);
  $getActors = getMovieActors($row['MovieID']);
  $array[] = array_merge_recursive($row, array("genre" => $getGenre),array("actors" => $getActors),array("director" => $row['DirectorFirstName'].' '.$row['DirectorLastName']));
}
return $array;
  }else{
    return false;
  }
}
function getMovieByID($id){
  global $db;
  $sql ="SELECT movies.MovieID,movies.MovieTitle,movies.MovieYear,movies.MoviePlot,movies.MovieLength,movies.MovieImg,movies.MovieTrailer, directors.DirectorFirstName, directors.DirectorLastName FROM movies
  INNER JOIN directors
  ON  directors.DirectorID = movies.DirectorID
  WHERE movies.MovieID = $id";
  $result = $db->query($sql);
  $getGenre = array();
  $getActors = array();
  if(!empty($result) && $result->num_rows > 0){
while ($row = $result->fetch_assoc()) {
  $getGenre = getMovieGenre($row['MovieID']);
  $getActors = getMovieActors($row['MovieID']);
  $rest = array_merge_recursive($row, array("genre" => $getGenre),array("actors" => $getActors),array("director" => $row['DirectorFirstName'].' '.$row['DirectorLastName']));
}
return $rest;
  }else{
    return false;
  }
}
function getMovieGenre($id){
  global $db;
  $sql ="SELECT genre.GenreID,genre.genreName FROM  moviesgenre
  INNER JOIN genre
  ON   genre.GenreID = moviesgenre.GenreID
  WHERE moviesgenre.MovieID = $id";
  $result = $db->query($sql);
  $genreItems = array();
  if($result->num_rows > 0){
    $i = 0;
    $array =  array();
    while($row = $result->fetch_assoc()){
      $array[$i] = $row;
      $i++;
    }
    return $array;
  }else{
    return false;
  }
}
function getMovieActors($id){
  global $db;
  $sql ="SELECT actors.ActorID,actors.ActorFirstName,actors.ActorLastName FROM  moviesactors
  INNER JOIN actors
  ON   actors.ActorID = moviesactors.ActorID
  WHERE moviesactors.MovieID = $id";
  $result = $db->query($sql);
  $genreItems = array();
  if($result->num_rows > 0){
    $i = 0;
    $array =  array();
    while($row = $result->fetch_assoc()){
      $array[$i] = $row;
      $i++;
    }
    return $array;
  }else{
    return false;
  }
}
 ?>
