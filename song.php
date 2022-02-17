<?php
Class Song {
    public $name;
    public $path;
    function __construct($name, $path) {
        $this->name = $name;
        $this->path = $path;
    }
    public static function getRandomAlbumSong(){
        $albums = Album::getAllAlbum();
        $album = $albums[rand(0,sizeof($albums) - 1)];
        $songs = $album->songs;
        return $songs[rand(0,sizeof($songs) - 1)];
    }
}
?>