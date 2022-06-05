<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::get('/logout', 'AuthController@logout');
Route::get('/profile','AuthController@profile');

Route::controller(BabyController::class)->group(function(){
    Route::post('/add-baby', 'insert');
    Route::get('/all-babies/{user_id}', 'index');
    Route::get('/baby-data/{id}', 'show');
    Route::post('/delete-baby/{id}', 'delete');
    Route::post('/update-baby/{id}', 'update');
});


Route::controller(TtrackersController::class)->group(function (){
    Route::post('/add-feeding/{user_id}','add_feeding');
    Route::post('/add-sleep/{user_id}','add_sleep');
    Route::post('/add-diaper/{user_id}','add_diaper');
});


Route::controller(HistoryController::class)->group(function (){
    Route::post('/add-history/{baby_id}', 'add_history');
    Route::get('/all-histories/{baby_id}', 'allhistories');
    Route::get('/history-data/{history_id}', 'show');
});

Route::controller(CryController::class)->group(function (){
    Route::get('/trackers-data/{baby_id}', 'trackers');
    Route::post('/insert/{baby_id}', 'insert');
    Route::post('/edit/{baby_id}', 'edit');
    Route::get('/cry/{baby_id}', 'cry');
});

Route::controller(PostController::class)->group(function(){
    Route::post('/add-post/{user_id}','insert');
    Route::get('/user-posts/{user_id}','userposts');
    Route::get('/cat-posts/{cat_id}','catposts');
    Route::get('/categories','cats');
    Route::post('/like/{user_id}/{post_id}','plike');
    Route::post('/unlike/{user_id}/{post_id}','punlike');
    Route::get('/show-post/{user_id}/{post_id}','show');
    Route::post('/edit-post/{user_id}/{post_id}','edit');
    Route::post('/delete-post/{user_id}/{post_id}','delete');
});

Route::controller(CommentController::class)->group(function(){
    Route::post('/comment/{user_id}/{post_id}','insert');
    Route::post('/comment-like/{user_id}/{comment_id}','clike');
    Route::post('/comment-unlike/{user_id}/{comment_id}','cunlike');
    Route::post('/edit-comment/{user_id}/{comment_id}','edit');
    Route::post('/delete-comment/{user_id}/{post_id}/{comment_id}','delete');
    Route::get('/pcomments/{post_id}','postcomments');
});