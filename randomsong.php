<?php 
require('song.php');
require('album.php');
require('mysql.php');
$song = Song::getRandomAlbumSong();
echo $song->path;
$sql = new MySQL("song");
$conn = $sql->openConnection();
Song::addView($conn, $song);
?>
