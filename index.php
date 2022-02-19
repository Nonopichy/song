<?php
    require('song.php');
    require('album.php');
    require('mysql.php');

    if(isset($_GET['search'])){
        $sql = new MySQL("song");
        $conn = $sql->openConnection();

        $search = $conn->query("SELECT * FROM albums WHERE title in ('".$_GET['search']."') ");

        if(mysqli_num_rows($search) > 0){
            $result = mysqli_fetch_assoc($search);
            var_dump($key);
           /*
            foreach ($result as $key){
                var_dump($key);
            }
            */
        }
    
    }
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
            if(!isset($_GET['search'])){
                echo 
                '
                <div class="assisted" onclick="setAssisted()">
                    <h1>Música mais ouvida:</h1>
                    <h2 id="assisted-song"></h2>
                </div>
                ';
            }
        ?>
        
        <script>
            document.getElementById("assisted-song").innerHTML=requestHttp("http://localhost/song/topsong.php").split("/")[2];
            
            function requestHttp(theUrl){
                var xmlHttp = new XMLHttpRequest();
                xmlHttp.open("GET", theUrl, false);
                xmlHttp.send(null);
                return xmlHttp.responseText;
            }

            function setAssisted(){
                var best = requestHttp("http://localhost/song/topsong.php");
                const info = best.split("/");
                document.getElementById("assisted-song").innerHTML=info[2];
                document.getElementById("album-now").innerHTML = info[1];
                document.getElementById("song-now").innerHTML = info[2];
                document.title = info[1]+' - '+info[2];
                var player = document.getElementById("player");
                player.src = best;
                player.play();
            }

            function setSong(best){
                const info = best.split("/");
                document.getElementById("album-now").innerHTML = info[1];
                document.getElementById("song-now").innerHTML = info[2];
                document.title = info[1]+' - '+info[2];
                var player = document.getElementById("player");
                player.src = best;
                player.play();
            }

            player.addEventListener("ended",function() {
                var request = requestHttp("http://localhost/song/randomsong.php");
                const info = request.split("/");
                document.getElementById("album-now").innerHTML = info[1];
                document.getElementById("song-now").innerHTML = info[2];
                document.title = info[1]+' - '+info[2];
                this.src = request;
                this.play();
            });
        </script>
    
        <?php
            if(!isset($_GET['search'])){
                echo `
                <br>
                <h3>As 10 mais ouvidas:</h3>`;
                Song::showTo(10);
             }
        ?>
    </body>
</html>