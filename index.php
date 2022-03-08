<?php
    require('song.php');
    require('album.php');
    require('mysql.php');
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>

        <style>
            .search input {
                width: 25%;
                height: 50px;
                margin-left: 35%;
                margin-top: 10px;
                position: absolute;
            }
        </style>

        <div class="search">
            <form action="">
                <input type="text" name="search" placeholder="Pesquise uma música...">
            </form>
        </div>
        
        <div class="player">
                <h3 id="album-now" style="text-align: center;">Title Waiting...</h1>
                <audio id="player" autoplay controls><source src="sound_dumb.mp3" type="audio/mpeg"></audio>
                <h4 id="song-now" style="text-align: center;">Song Waiting...</h1>
         </div>

        <?php
            if(!empty($_GET['album'])){


                $album = Album::findAlbum($_GET['album'], 'name');
                if($album != null){
                    echo $album->name;
                    $sql = new MySQL("song");
                    $conn = $sql->openConnection();
                    $search = $sql->getContains('*','albums','album', $album->name);
                    foreach ($search as $key){
                        $song = Song::findSongTitle($key['title']);
                        $album = $song->album->name;
                        $title = str_split($key['title'], 32)[0];
                        echo '<div class="song" onclick="setSongSingle(\''.Song::findSongTitle($key['title'])->path.'\')">&#160&#160&#160'.
                        str_replace(".mp3", "",explode('c-', $title)[0]).'...<br>&#160&#160&#160> VIEWS: '.$key['views'].' ('.$key['category'].') <br><br>'
                        .'</div>';
                    }
                }
            
            }
            else if(empty($_GET['search'])){
                echo 
                '
                <div class="assisted" onclick="setAssisted()">
                    <h1>Música mais ouvida:</h1>
                    <h2 id="assisted-song"></h2>
                </div>
                ';
            } else {
                $sql = new MySQL("song");
                $conn = $sql->openConnection();
                $search = $sql->getContains('*','albums','title', $_GET['search']);
                foreach ($search as $key){
                    $song = Song::findSongTitle($key['title']);
                    $album = $song->album->name;
                    $title = str_split($key['title'], 32)[0];
                    echo '<div class="song" onclick="setSongSingle(\''.Song::findSongTitle($key['title'])->path.'\')">&#160&#160&#160 <a href="http://localhost/song/?album='.$album.'" class="album">'.$album.'</a>&#160-&#160'.
                    str_replace(".mp3", "",explode('c-', $title)[0]).'...<br>&#160&#160&#160> VIEWS: '.$key['views'].' ('.$key['category'].') <br><br>'
                    .'</div>';
                }
            }
        ?>
        
        <script>
             document.cookie = "loop=false";
            document.getElementById("assisted-song").innerHTML=requestHttp("http://localhost/song/topsong.php").split("/")[2];
            
            function getCookie(cname) {
                let name = cname + "=";
                let decodedCookie = decodeURIComponent(document.cookie);
                let ca = decodedCookie.split(';');
                for(let i = 0; i <ca.length; i++) {
                    let c = ca[i];
                    while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                    }
                    if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                    }
                }
                return "";
            }

            function requestHttp(theUrl){
                var xmlHttp = new XMLHttpRequest();
                xmlHttp.open("GET", theUrl, false);
                xmlHttp.send(null);
                return xmlHttp.responseText;
            }

            function setDisplaySong(info){
                document.getElementById("album-now").innerHTML = info[1];
                document.getElementById("song-now").innerHTML = info[2];
                document.title = info[1]+' - '+info[2];
            }
            
            function playSong(src){
                var player = document.getElementById("player");
                player.src = src;
                player.play();
            }

            function setAssisted(){
                var best = requestHttp("http://localhost/song/topsong.php");
                const info = best.split("/");
                document.getElementById("assisted-song").innerHTML=info[2];
                setDisplaySong(info);
                playSong(best);
            }

            function addView(best){
                requestHttp("http://localhost/song/view.php?song="+best);
            }

            function setSong(best){
                addView(best);
                setDisplaySong(best.split("/"));
                playSong(best);
            }
            function setSongNoView(best){
                setDisplaySong(best.split("/"));
                playSong(best);
            }

            function setSongSingle(best){
                document.cookie = "loop=true";
                setSong(best);
            }

            player.addEventListener("ended",function() {
                if(getCookie('loop')=="false"){
                    var request = requestHttp("http://localhost/song/randomsong.php");
                    setSongNoView(request);
                } else {
                    this.play();
                }
            });
        </script>
    
        <?php
            if(empty($_GET['search']) && empty($_GET['album'])){
                echo `<br><h3>As 10 mais ouvidas:</h3><br>`;
                Song::showTo(10);
             }
        ?>
    </body>
</html>