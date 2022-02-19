<?php 
require('song.php');
require('album.php');
require('mysql.php');
$sql = new MySQL("song");
$conn = $sql->openConnection();
$bigger_view = mysqli_fetch_assoc($conn->query("SELECT MAX(views) as max_views FROM albums;"))['max_views'];
$song = mysqli_fetch_assoc($conn->query("SELECT * FROM albums WHERE views='".$bigger_view."';"));
$real_song =  Song::findSongTitle($song['title']);
if($real_song!=null)
    echo $real_song->path;
?>
