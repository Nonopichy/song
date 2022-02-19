<?php 
require('song.php');
require('album.php');
require('mysql.php');
$song = Song::getRandomAlbumSong();
echo $song->path;
$sql = new MySQL("song");
$conn = $sql->openConnection();
$title = mysqli_escape_string($conn,$song->name);
$search = $conn->query("SELECT `views` FROM `albums` WHERE title='".$title."'");
if (mysqli_num_rows($search) > 0) {
    $views = intval(mysqli_fetch_assoc($search)['views']) + 1;
    $conn->query( "UPDATE `albums` SET `views`='".$views."' WHERE `title`='".$title."'");
} else{
    $conn->query("INSERT INTO `albums`(`title`, `views`,`category`) VALUES ('".$title."','0','".$song->category."')");
}
?>
