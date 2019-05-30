<?php
class Movie
{
  public function addMovie($movieDirector,$movieTitle,$movieGenre,$movieActors,$movieYear,$moviePlot,$movieLength,$movieImg,$movieTrailer){
    global $db;
    $sqlMovie = "INSERT INTO movies (DirectorID,MovieTitle,MovieYear,MoviePlot,MovieLength,MovieImg,MovieTrailer) VALUES('$movieDirector','$movieTitle','$movieYear','$moviePlot','$movieLength','$movieImg','$movieTrailer')";
    $result = $db->query($sqlMovie);
    if ($result){
      $lastMovieID = $db->insert_id;
  if (!empty($movieActors) || !empty($movieGenre) ) {
      $actorsSeparated = implode(",", $movieActors);
      $getActorsTags = explode(',', $actorsSeparated);
      foreach($getActorsTags as $actorID) {
        $sqlActors = "INSERT INTO moviesactors (MovieID, ActorID) VALUES ('$lastMovieID', '$actorID')";
        $result = $db->query($sqlActors);
      }

      $GenreSeparated = implode(",", $movieGenre);
      $getGenreTags = explode(',', $GenreSeparated);
      foreach($getGenreTags as $genreID) {
        $sqlGenre = "INSERT INTO moviesgenre (MovieID, GenreID) VALUES ('$lastMovieID', '$genreID')";
        $result = $db->query($sqlGenre);
      }
      }
      return $result;
    }

  }
    public function getMoviesGenreList(){
      global $db;
      $sql ="SELECT * FROM genre ORDER BY GenreName";
      $result = $db->query($sql);
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
    public function getMoviesDirectorList(){
      global $db;
      $sql ="SELECT * FROM directors ORDER BY DirectorFirstName";
      $result = $db->query($sql);
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
    public function getMoviesActorsList(){
      global $db;
      $sql ="SELECT * FROM actors ORDER BY actorFirstName";
      $result = $db->query($sql);
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
    // cURL hämta data från url json
  public function display_data(){
    $url = "http://localhost/php/moviesDB-API/rest/api.php?action=movies&list";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL,$url);
    $response = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($response);
    return  $result;
  }
  public function getMovieByID($id){
    $url = "http://localhost/php/moviesDB-API/rest/api.php?action=movies&movie_id=$id";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL,$url);
    $response = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($response);
    return  $result;
  }
  public function getNewAddedMovies(){
    global $db;
    $sql ="SELECT * FROM movies ORDER BY MovieYear DESC LIMIT 6";
    $result = $db->query($sql);
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
  public function updateMovie($id,$movieDirector,$movieTitle,$movieGenre,$movieActors,$movieYear,$moviePlot,$movieLength,$movieImg,$movieTrailer){
    global $db;
    $getID = "SELECT * FROM movies
        WHERE MovieID = $id";
    $result = $db->query($getID);
    $row = $result->fetch_array();
    $getImg = $row['MovieImg'];
    if ($result) {
    unlink('img/'.$getImg);
    $sql ="UPDATE movies SET DirectorID = '$movieDirector', MovieTitle = '$movieTitle', MovieYear = '$movieYear', MoviePlot = '$moviePlot', MovieLength = '$movieLength', MovieImg = '$movieImg', MovieTrailer = '$movieTrailer' WHERE MovieID = $id";
    $result = $db->query($sql);

    if ($result) {
      $sqlActorsDel ="DELETE FROM moviesactors WHERE MovieID = $id";
      $sqlGenreDel ="DELETE FROM moviesgenre WHERE MovieID = $id ";
      $result = $db->query($sqlActorsDel);
      $result = $db->query($sqlGenreDel);
  if (!empty($movieActors) || !empty($movieGenre) ) {
      $actorsSeparated = implode(",", $movieActors);
      $getActorsTags = explode(',', $actorsSeparated);
      foreach($getActorsTags as $actorID) {
        $sqlActorsAdd = "INSERT INTO moviesactors (MovieID, ActorID) VALUES ('$id', '$actorID')";
        $result = $db->query($sqlActorsAdd);
      }
      $GenreSeparated = implode(",", $movieGenre);
      $getGenreTags = explode(',', $GenreSeparated);
      foreach($getGenreTags as $genreID) {
        $sqlGenreAdd = "INSERT INTO moviesgenre (MovieID, GenreID) VALUES ('$id', '$genreID')";
        $result = $db->query($sqlGenreAdd);
      }
      }
      return $result;
    }
        }
  }
  public function deleteMovie($id){
    global $db;
    $getID = "SELECT * FROM movies
        WHERE MovieID = $id";
    $result = $db->query($getID);
    $row = $result->fetch_array();
    $getImg = $row['MovieImg'];
    if($result){
      unlink('img/'.$getImg); // tabort bilden från folder också
      $sql ="DELETE FROM movies
      WHERE MovieID = $id";
      $result = $db->query($sql);
    return true;
    }else{
      return false;
    }
  }

  public function getMovieGenre($id){

    global $db;
    $sql ="SELECT * FROM  moviesgenre
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
  public function getMovieActors($id){
    global $db;
    $sql ="SELECT * FROM  moviesactors
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
  public function addGenre($genreName){
    global $db;
    $sql ="INSERT INTO genre (GenreName) VALUES ('$genreName')";
    $result = $db->query($sql);
    if($result){
      return true;
    }else{
      return false;
    }
  }
  public function editGenre($id,$genreName){
    global $db;
    $sql ="UPDATE genre SET GenreName = '$genreName' WHERE GenreID = $id";
    $result = $db->query($sql);
    if($result){
      return true;
    }else{
      return false;
    }
  }
  public function getGenreByID($id){
    global $db;
    $sql ="SELECT * FROM genre
    WHERE GenreID = $id";
    $result = $db->query($sql);

    if(!empty($result) && $result->num_rows > 0){
      while ($row = $result->fetch_assoc()) {
        return $row;
      }
        }else{
          return false;
        }
      }
  public function deleteGenre($id){
    global $db;
    $sql ="DELETE FROM genre
    WHERE GenreID = $id";
    $result = $db->query($sql);
    if($result){
    return true;
    }else{
      return false;
    }
  }
  public function getMoviesinGenre($id){
    global $db;
    $sql ="SELECT * FROM  moviesgenre
    INNER JOIN movies
    ON   movies.MovieID = moviesgenre.MovieID
    WHERE moviesgenre.GenreID = $id";
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
  public function addDirector($directorFirstName,$directorLastName,$directorBirthday){
    global $db;
    $sql ="INSERT INTO directors (DirectorFirstName,DirectorLastName,DirectorBirthday) VALUES ('$directorFirstName','$directorLastName', '$directorBirthday')";
    $result = $db->query($sql);
    if($result){
      return true;
    }else{
      return false;
    }
  }
  public function editDirector($id,$directorFirstName,$directorLastName,$directorBirthday){
    global $db;
    $sql ="UPDATE directors SET DirectorFirstName = '$directorFirstName', DirectorLastName = '$directorLastName', DirectorBirthday = '$directorBirthday' WHERE DirectorID = $id";
    $result = $db->query($sql);
    if($result){
      return true;
    }else{
      return false;
    }
  }
  public function deleteDirector($id){
    global $db;
    $sql ="DELETE FROM directors
    WHERE DirectorID = $id";
    $result = $db->query($sql);
    if($result){
    return true;
    }else{
      return false;
    }
  }
  public function getDirectorByID($id){
    global $db;
    $sql ="SELECT * FROM directors
    WHERE DirectorID = $id";
    $result = $db->query($sql);

    if(!empty($result) && $result->num_rows > 0){
      while ($row = $result->fetch_assoc()) {
        return $row;
      }
        }else{
          return false;
        }
      }
  public function getDirectorMovies($id){
    global $db;
    $sql ="SELECT * FROM  directors
    INNER JOIN movies
    ON   movies.DirectorID = directors.DirectorID
    WHERE directors.DirectorID = $id";
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
  public function addActor($actorFirstName,$actorLastName,$actorBirthday){
    global $db;
    $sql ="INSERT INTO actors (ActorFirstName,ActorLastName,ActorBirthday) VALUES ('$actorFirstName','$actorLastName', '$actorBirthday')";
    $result = $db->query($sql);
    if($result){
      return true;
    }else{
      return false;
    }
  }
  public function editActor($id,$actorFirstName,$actorLastName,$actorBirthday){
    global $db;
    $sql ="UPDATE actors SET ActorFirstName = '$actorFirstName', ActorLastName = '$actorLastName', ActorBirthday = '$actorBirthday' WHERE ActorID = $id";
    $result = $db->query($sql);
    if($result){
      return true;
    }else{
      return false;
    }
  }
  public function deleteActor($id){
    global $db;
    $sql ="DELETE FROM actors
    WHERE ActorID = $id";
    $result = $db->query($sql);
    if($result){
    return true;
    }else{
      return false;
    }
  }
  public function getActorByID($id){
    global $db;
    $sql ="SELECT * FROM actors
    WHERE ActorID = $id";
    $result = $db->query($sql);

    if(!empty($result) && $result->num_rows > 0){
  while ($row = $result->fetch_assoc()) {
    return $row;
  }
    }else{
      return false;
    }
  }
  public function getActorMovies($id){
    global $db;
    $sql ="SELECT * FROM  moviesactors
    INNER JOIN movies
    ON   movies.MovieID = moviesactors.MovieID
    WHERE moviesactors.ActorID = $id";
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
}

?>
