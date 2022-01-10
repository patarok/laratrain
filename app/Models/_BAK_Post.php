<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class Post {

    public $estragon_id;
    public $todo_id;
    public $title;
    public $excerpt;
    public $date;
    public $body;

    //these parameters should not have a default value in production
    public function __construct($title, $excerpt, $date, $body, $estragon_id = 0, $todo_id = 0){

        $this->estragon_id =  $estragon_id;
        $this->todo_id = $todo_id;
        $this->title = $title;
        $this->excerpt = $excerpt;
        $this->date = $date;
        $this->body = $body;
    }



    public static function all(){
        $files = File::files(resource_path('posts/'));

        $posts = [];

        foreach($files as $file)
        {

            $document = YamlFrontMatter::parseFile($file);
            $estragon_idFetch = [];
            $todo_idFetch = [];

            preg_match('/(?<=estragon_id)[0-9]*?(?=-post)/', $file->getFilename(), $estragon_idFetch);
            preg_match('/(?<=post-no-)[0-9]*?(?=.html)/', $file->getFilename(), $todo_idFetch);


            $posts[] = new Post(
                $document->title,
                $document->excerpt,
                $document->date,
                $document->body(),
                $estragon_idFetch[0][0],
                $todo_idFetch[0][0],
            );
        }

        return $posts;
    }

    public static function find($estragon_id, $todo_id){
        if(!file_exists($f_uri = resource_path('posts/estragon_id'.$estragon_id.'-post-no-'.$todo_id.'.html'))){
            throw new ModelNotFoundException();
        }

        return cache()->remember("posts.{$estragon_id}.{$todo_id}", /*now()->addDay()*/ CCC_TIME, function() use ($estragon_id, $todo_id, $f_uri) {
            $article = YamlFrontMatter::parse(file_get_contents($f_uri));
            return ['postContent' => $article, 'todo_id' => $todo_id, 'estragon_id' => $estragon_id, 'f_uri' => $f_uri];
        });
    }

}
