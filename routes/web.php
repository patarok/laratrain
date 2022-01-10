<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $Posts = Post::all();

    return view('all', ['Posts' => $Posts]);
});

/*Route::get('/estragon_{estragon_id}/post_{todo_id}', function ($estragon_id,$todo_id) {
        $postContents = Post::find($estragon_id, $todo_id);

/*        if(!$postContents){
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException();
        }*/

//    return view('post', ['postContent' => $postContents['postContent'], 'todo_id' => $todo_id]);
//})->where('id', '[0-9]+');*/

Route::get('/post_{id}', function ($id) {
    $mPost = Post::findOrFail($id);
    return view('post', ['postContent' => $mPost]);
});

