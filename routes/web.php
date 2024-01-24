<?php

use App\Models\post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('home', 'App\Http\Controllers\HomeController@showWelcome');
Route::get('about','App\Http\Controllers\AboutController@showDetails');
Route::get('profile/{name}','App\Http\Controllers\ProfileController@showProfile');



Route::get('/', function () {
    return view('welcome');
});



//Route::get('about',function() {
//    return 'About Content';
//});

Route::get('about/directions',function() {
    return'Directions go here';
});

Route::any('submit-form',function() {
    return 'Process Form';
});

Route::get('about/{theSubject}', 'App\Http\Controllers\AboutController@showSubject');

Route::get('about/classes/{theSubject}', function ($theSubject) {
    return " Content on $theSubject ";
});

Route::get('about/classes/{theArt}/{thePrince}',function ($theArt, $thePrince) {
    return "The product: $theArt and $thePrince";
});

Route::get('where', function() {
    return Redirect::route('direction');
});


Route::get('/insert', function (){
   DB::insert('insert into posts(title, body, is_admin) values(?,?,?)', ['PHP with Laravel', 'Laravel is the best framework !',0] );
   return 'DONE';
});


Route::get('/read', function () {
    $result = DB::select('select * from posts where id = ?', [1]);
//    return  $result;
    foreach ($result as $post){
        return $post->title;
    }
});


Route::get('update', function (){
    $update = DB::update('update posts set title = "New Title haha" where id > ?', [1]);
    return $update;
});


Route::get('delete', function () {
    $deleted = DB::delete('delete from posts where id = ?',[3]);
    return $deleted;
});


Route::get('readAll', function (){
   $posts = Post::all();
   foreach ($posts as $p){
       echo $p -> title ." ". $p -> body;
       echo "<br>";
   }
});

Route::get('findId', function (){
   $posts = post::where('id','>=', 1)
       -> where('title','PHP with Laravel')
       -> where('body','like','%new%')
       -> orderBy('id', 'desc')
       -> take(10)
       -> get();
    foreach ($posts as $p){
        echo $p -> title ;
        echo "<br>";
    }
});
//36
Route::get('insertORM', function (){
   $p = new post;
   $p->title = 'insert ORM';
   $p->body = 'INSERTED done done ORM';
   $p->is_admin = 1;
   $p->save();
});
//37
Route::get('updateORM', function (){
   $p = post::where('id',6)->first();
   $p->title = 'updated ORM';
   $p->body = 'updated Ahihii DONE DONE';
   $p->save();
});

//38
Route::get('deleteORM', function (){
   post::where('id', '>=', 8)
        ->delete();
});

Route::get('destroyORM', function (){
   post::destroy([18,20]);
});
