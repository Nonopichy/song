<?php

require('song.php');
require('album.php');

echo '<audio id="player" hidden="true" autoplay controls><source src="'.Song::getRandomAlbumSong()->path.'" type="audio/mpeg"></audio>';

?>

<html>
    <body>
        <script>
            function requestHttp(theUrl){
                var xmlHttp = new XMLHttpRequest();
                xmlHttp.open( "GET", theUrl, false );
                xmlHttp.send( null );
                return xmlHttp.responseText;
            }
            var player = document.getElementById("player");
            player.addEventListener("ended",function() {
                this.src = requestHttp("http://localhost/song/randomsong.php");
                this.play();
            });
        </script>
    </body>
</html>