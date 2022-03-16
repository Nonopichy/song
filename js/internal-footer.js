 /*
  * Load cookies, last song listener.
  */
 function loadLastSong(){
    var time = getCookie("time");
    var src = getCookie("src");
    var album_now = getCookie("album-now");
    var song_now = getCookie("song-now");
    var title = getCookie("title");
    var volume = getCookie("volume");
    if(time != null && src != null && album_now != null && song_now != null && title != null && volume != null){
        setSongNoView(src);
        var player = document.getElementById("player");
        player.currentTime = time;
        document.getElementById("album-now").innerHTML = album_now;
        document.getElementById("song-now").innerHTML = song_now;
        document.title = title;
        player.volume = volume;
    }
}
loadLastSong();
/*
 * Save in cookies, last song listener.
 */
window.onbeforeunload = function (e) {
    var player = document.getElementById("player");
    document.cookie = "time="+player.currentTime;
    document.cookie = "src="+player.src;
    document.cookie = "album-now="+document.getElementById("album-now").textContent;
    document.cookie = "song-now="+document.getElementById("song-now").textContent;
    document.cookie = "title="+document.title;
    document.cookie = "volume="+player.volume;
}
/*
 * Looping song if not random, else random.
 */
player.addEventListener("ended",function() {
    if(getCookie('loop')=="false"){
        var request = requestHttp("http://localhost/song/randomsong.php");
        setSongNoView(request);
    } else {
        this.play();
    }
});