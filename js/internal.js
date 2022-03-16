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

            function changePage(link){
                window.location.href = link;
            }
