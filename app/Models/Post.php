<?php

namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class Post
{

    public $title;

    public $excerpt;

    public $date;

    public $body;

    public $slug;

    public function __construct($title, $excerpt, $date, $body, $slug)
    {
        $this->title = $title;
        $this->excerpt = $excerpt;
        $this->date = $date;
        $this->body = $body;
        $this->slug = $slug;
    }
    public static function all() {
        // File Facade - class that gives a static access to all sort of functionality
        //COLLECT: Collect an array and wrap in within a Collection Object (we can map, filter, loop over,pull that array)
        return cache()->rememberForever('posts.all', function () {
            return collect(File::files(resource_path("posts")))
                ->map(function ($file) {
                    return YamlFrontMatter::parseFile($file);
                    })
                ->map(function ($document) {
                    return new Post(
                        $document->title,
                        $document->excerpt,
                        $document->date,
                        $document->body(),
                        $document->slug
                        );
                    })
                ->sortByDesc('date');
        });

        

            // IDENTICAL to this
            // $posts = array_map(function($file) {
            //     $document = YamlFrontMatter::parseFile($file);

            //     return new Post(
            //         $document->title,
            //         $document->excerpt,
            //         $document->date,
            //         $document->body(),
            //         $document->slug
            //     );
            // }, $files);


        // $files =  File::files(resource_path("posts/"));

        //loop over each of the files and return new array
        // return array_map(fn($file) => $file->getContents(), $files);
        // same as :
        // return array_map(function ($file) {
        //     return $file->getContents();
        // }, $files);
    }

    public static function find($slug) 
    {
        // Of all the blog posts, find the one with a slug that matches the one that was requested
        return static::all()->firstWhere('slug', $slug);


        // global helper PATH functions: app_path(), base_path(), resource_path()
        // if (! file_exists($path = resource_path("posts/{$slug}.html"))) {
        //     throw new ModelNotFoundException();
        // }

        // return cache()->remember("posts.{$slug}", 1200, fn () => file_get_contents($path));

    }
}

