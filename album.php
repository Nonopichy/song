<?php
Class Album {
    public $name;
    public $songs = array();
    function __construct($name) {
        $this->name = $name;
    }
    public function addSong($song){
        array_push($this->songs,$song);
    }
    public static function getFolderAll($folder){
        $list = array();
        if ($handle = opendir($folder)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..")
                    array_push($list,$entry);
            }
            closedir($handle);
        }
        return $list;
    }
    public static function getAllAlbum(){
        $albums = array();
        foreach (Album::getFolderAll("albums") as $one) {
            $album = new Album($one);
            foreach (Album::getFolderAll("albums/".$one) as $two) {
                $song = new Song($two,"albums/".$one."/".$two);
                $album->addSong($song);
            }
            array_push($albums,$album);
        }
        return $albums;
    }
}
?>