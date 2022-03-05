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
        $sql = new MySQL("song");
        $conn = $sql->openConnection();
        $albums = array();
        foreach (Album::getFolderAll("albums") as $one) {
            $album = new Album($one);
            foreach (Album::getFolderAll("albums/".$one) as $two) {
                $song = new Song($two,"albums/".$one."/".$two, $album);
                $album->addSong($song);
                Song::addView($conn, $song, false);
            }
            array_push($albums,$album);
        }
        return $albums;
    }
    public static function findAlbum($find, $type){
        $albums = Album::getAllAlbum();
        foreach ($albums as $one){
            if($one->$type == $find)
                return $one;
        }
        return null;
    }
}
?>