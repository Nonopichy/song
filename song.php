<?php
Class Song {
    public $name;
    public $path;
    public $album;
    public $image;
    function __construct($name, $path, $album, $image) {
        $this->name = $name;
        $this->path = $path;
        $this->album = $album;
        @$category = str_replace(".mp3", "",explode('c-', $this->name)[1]);
        $this->category = $category;
        $this->image = $image;
    }
    public static function getRandomAlbumSong(){
        $albums = Album::getAllAlbum();
        $album = $albums[rand(0,sizeof($albums) - 1)];
        $songs = $album->songs;
        return $songs[rand(0,sizeof($songs) - 1)];
    }
    public static function findSong($find, $type){
        $albums = Album::getAllAlbum();
        foreach ($albums as $one){
            foreach ($one->songs as $two){
                if($two->$type == $find || strpos($two->$type, $find))
                    return $two;
            }
        }
        return null;
    }
    public static function findSongTitle($title){
        return Song::findSong($title, 'name');
    }
    public static function showTo($limit){
        $search = Song::orderSong($limit);
        $top = 1;
        foreach ($search as $key){
            $title = str_split($key['title'], 32)[0];
            echo '<div class="song" onclick="setSongSingle(\''.Song::findSongTitle($key['title'])->path.'\')">'.
            $top.'. '.str_replace(".mp3", "",explode('c-', $title)[0]).'...<br>> VIEWS: '.$key['views'].' ('.$key['category'].') <br><br>'
            .'</div>';
            $top++;
        }
    }
    public static function orderSong($limit){
        $sql = new MySQL("song");
        $conn = $sql->openConnection();
        return $conn->query("SELECT * FROM albums ORDER BY views DESC LIMIT ".$limit);

    }
    public static function addView($conn, $song, $addview){
        $title = mysqli_escape_string($conn,$song->name);
        $search = $conn->query("SELECT `views` FROM `albums` WHERE title='".$title."'");
        if (mysqli_num_rows($search) > 0) {
            if($addview){
                $views = intval(mysqli_fetch_assoc($search)['views']) + 1;
                $conn->query( "UPDATE `albums` SET `views`='".$views."' WHERE `title`='".$title."'");
            }
        } else{
            $conn->query("INSERT INTO `albums`(`title`, `views`,`category`,`album`) VALUES ('".$title."','0','".strtoupper($song->category)."','".$song->album->name."')");
        }
    }
}
?>