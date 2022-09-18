<?php

use Illuminate\Support\Facades\Route;
//use App\Models\User;
use App\Http\Controllers\StudViewController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\APIController;
use App\Http\Controllers\APIAbc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    return view('welcome');
});

// connect to database
Route::get('/user', [StudViewController::class,'index']);




// there are fours types of route
// web, api, console, and channel



Route::match( ['get', 'post'], '/match', function(){
    return $_SERVER['REQUEST_METHOD'];
});

// accept all request
Route::any('/abc', function(){
    return 'abc';
});



// some method of Route
Route::get( '/there', function (){
    return 'there router';
});
Route::post('', function(){

});
Route::put( '', function (){

});

Route::patch('', function (){

});
Route::delete('', function (){

});
Route::match( ['post', 'get', 'delete'], '/', function (){
    // some actions in here
    return view('welcome');
});


Route::redirect('/here', '/there');



// if your route only need to return view , you may use the Route::view method like the redirect method


Route::view( '/abc', 'welcome')->name('example');


// you may constrain the format of the route parameter using the where method on a coute
// the where method accepts the name of the parameter and regular expression defining how the parameter should be constrained:


Route::get('/useConstrain/{id}', function($id){
    echo '<br>'.$id;
    $url = route('example');
    return redirect()->route('example');
});


// we can use global constraint



Route::middleware( ['first','second'])->group( function(){
    Route::get('/first', function(){
        echo 'asdfjkl';
    });
    Route::get('second', function (){
       echo 'safasdf';
    });
});
// middleware parameter

Route::get('/parameter/{id}',function($id){
    echo '<br>end';
})->middleware('para:editor,sao ma no nhieu quy tac the');


// provide crud actions
Route::resource('/photos', 'App\Http\Controllers\PhotoController');



// provide for api

Route::apiResources([
    '/abc'=> 'App\Http\Controllers\APIAbc',
    '/api' => 'App\Http\Controllers\APIController'
]);
// Nested resource
// this route will register a nested resource that may be accessed with urls like:
//    photos/{photo}/comments/{comment}
Route::resource('photos.comments', 'App\Http\Controllers\PhotoController');


// request

Route::get('/studyRequest', function( Request $request){
    $url = $request->fullUrl();
    return $url;
});


// retrive http method
Route::get('/httpMethod', function( Request $request){
    $method = $request->method();
    if( $request->isMethod('GET')){
        return 'Method get nhe';
    }
    return $method;
});


// retrive all infor in request

Route::get('/getAllInfor', function(Request $request){
    return $request->query();
});


// reponse
Route::get('/useResponse', function(){
    return response('Tong Van Phuc', 200)
                    ->header('Content-Type', 'text/plain');
});




// use database
Route::get('/users', function(){
    $users = DB::select('select * from customers');
//    dd($users);
    return $users[0]->first_name . ' '. $users[0]->last_name;
});

// insert into database
Route::get('/users/{id}', function($id){
//    $tmp = DB::insert('insert into customers values(?,?,?,?,?,?)',[$id, 'Vu','Duong','vuduong@gmail.com','vuduong', 'Thanh Hoa']);

})->where( 'id', '[0-9]+');



// multiple connection
Route::get( '/multipleConnection', function(){
//    $users = DB::connection('pgsql')->select('select * from patient;');
    DB::transaction(function(){
       DB::insert('insert into customers values (?,?,?,?,?,?)', ['098765432101', 'Pham', 'Dong', 'phamdong@gmail.com','phamdong', 'Thanh Hoa']);
       DB::delete('delete from customers where id = ?', ['098765432101']);
    });
    return 'Transaction successfullly';
});


