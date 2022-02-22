<?php 

if(empty($_GET['song']))
    exit;

require('song.php');
require('album.php');
require('mysql.php');

$song = Song::findSong($_GET['song'],'path');

if($song == null)
    exit;

$sql = new MySQL("song");
$conn = $sql->openConnection();
Song::addView($conn, $song,true);

?>
