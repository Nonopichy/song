<?php
Class Album {
    public $name;
    public $songs = array();
    public $image;
    function __construct($name) {
        $this->name = $name;
    }
    public function addSong($song){
        array_push($this->songs,$song);
    }
    public function setImage($image){
        $this->image = $image;
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
            if(file_exists("albums/".$one."/!.png")!== false){
                $album->setImage("albums/".$one."/"."!.png");
            }
            foreach (Album::getFolderAll("albums/".$one) as $two) {
                 if(!(strpos($two,".png")!== false)){
                $image = "albums/".$one."/".substr($two, 0, -4). '.png';
                if(file_exists($image))
                    $song = new Song($two,"albums/".$one."/".$two, $album, $image);
                else
                    $song = new Song($two,"albums/".$one."/".$two, $album, null);
                $album->addSong($song);
                Song::addView($conn, $song, false);
                 }

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