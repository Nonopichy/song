<?php 
require('song.php');
require('album.php');
echo Song::getRandomAlbumSong()->path;
?>
