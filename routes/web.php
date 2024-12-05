<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\Register;
use App\Http\Controllers\Blogs;
use App\Http\Controllers\Datatable;
use Illuminate\Support\Facades\Route;

Route::get('/register', function () {
    return view('Register');
});
Route::post('/register', [Register::class,'registers']);
Route::get('/login', function () {
    return view('Login');
});

Route::post('/login', [Register::class,'login']);
Route::view('/','Blogbackend/Home');

Route::get('/', function () {
    return view('Blogbackend.home');
})->name('home');


Route::get('/Myprofile', function () {
    return view('Blogbackend.Myprofile');
})->name('Myprofile');

Route::get('/Deleteuser/{id}', [UserController::class, 'deleteuser']);

Route::view('/AddBlog', 'Blogbackend.Utils.AddBlog');
Route::view('/EditUser','Blogbackend.Utils.Edituser');
Route::get('/Edituser/{id}', [UserController::class, 'editUser']);

Route::post('/AddBlog', [Blogs::class,'addblogdata']);
Route::post('/getblogAjax', [Datatable::class, 'getblogAjax']);
Route::post('/getUsersAjax', [Datatable::class, 'getUsersAjax']);
Route::post('/updateprofile', [Register::class,'updateprofile']);
Route::put('/updateuser/{id}', [UserController::class, 'updateuser'])->name('updateuser');


Route::get('/updateprofile', function () {
    return view('Blogbackend.Updateprofile');
})->name('updateprofile');

Route::get('/Users', function () {
    return view('Blogbackend.Users');
})->name('Users');

Route::get('/Blog', function () {
    return view('Blogbackend.Blog');
})->name('Blog');

Route::get('/BlogCat', function () {
    return view('Blogbackend.BlogCat');
})->name('BlogCat');

Route::get('/News', function () {
    return view('Blogbackend.News');
})->name('News');

Route::get('/NewsCat', function () {
    return view('Blogbackend.NewsCat');
})->name('NewsCat');

Route::get('/Pages', function () {
    return view('Blogbackend.Pages');
})->name('Pages');

Route::get('/Company', function () {
    return view('Blogbackend.CompanyProfile');
})->name('Company');

Route::get('/Logout', function () {
    return view('Blogbackend.Logout');
})->name('Logout');


