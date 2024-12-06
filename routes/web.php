<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\Register;
use App\Http\Controllers\Blogs;
use App\Http\Controllers\Newsarticle;
use App\Http\Controllers\Datatable;
use App\Models\Blogcat;
use App\Models\Newscat;
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
Route::get('/Deleteblog/{id}', [Blogs::class, 'deleteblog']);
Route::get('/DeleteNews/{id}', [Newsarticle::class, 'deletenews']);
Route::get('/Deleteblogcat/{id}', [Blogs::class, 'deleteblogcat']);
Route::get('/Deletenewscat/{id}', [Newsarticle::class, 'deletenewscat']);
Route::get('/Deletepages/{id}', [Newsarticle::class, 'deletepages']);

Route::view('/AddPage', 'Blogbackend.Utils.AddPage');
Route::view('/AddNewsCat', 'Blogbackend.Utils.AddNewsCat');
Route::view('/AddBlogCat', 'Blogbackend.Utils.AddBlogCat');
Route::view('/AddNews', 'Blogbackend.Utils.AddNews');
Route::view('/AddBlog', 'Blogbackend.Utils.AddBlog');
Route::view('/EditUser','Blogbackend.Utils.Edituser');


Route::get('/Editpages/{id}', [Newsarticle::class, 'editpages']);
Route::get('/Editnewscat/{id}', [Newsarticle::class, 'editnewscat']);
Route::get('/Editblogcat/{id}', [Blogs::class, 'editblogcat']);
Route::get('/Edituser/{id}', [UserController::class, 'editUser']);
Route::get('/Editblog/{id}', [Blogs::class, 'editblog']);
Route::view('/Editblog','Blogbackend.Utils.Editblog')->name('Editblog');
Route::get('/EditNews/{id}', [Newsarticle::class, 'editnews']);
Route::post('/AddNews', [Newsarticle::class,'addnewsdata']);
Route::post('/AddBlog', [Blogs::class,'addblogdata']);
Route::post('/AddBlogCat', [Blogs::class,'addblogcat']);
Route::post('/UpdateBlogCat', [Blogs::class,'updateblogcat']);
Route::post('/AddNewsCatdata', [Newsarticle::class,'addnewscatdata']);
Route::post('/AddPageData', [Newsarticle::class,'addpagedata']);

Route::post('/UpdateNewsCat', [Newsarticle::class,'updatenewscat']);

Route::post('/getpagesAjax', [Datatable::class, 'getpagesAjax']);
Route::post('/getnewscatAjax', [Datatable::class, 'getnewscatAjax']);
Route::post('/getblogcatAjax', [Datatable::class, 'getblogcatAjax']);
Route::post('/getnewsAjax', [Datatable::class, 'getnewsAjax']);
Route::post('/getblogAjax', [Datatable::class, 'getblogAjax']);
Route::post('/getUsersAjax', [Datatable::class, 'getUsersAjax']);
Route::post('/updateprofile', [Register::class,'updateprofile']);
Route::put('/updateuser/{id}', [UserController::class, 'updateuser'])->name('updateuser');
Route::post('/UpdateNews', [Newsarticle::class,'updatenews']);

Route::post('/UpdatePageData', [Newsarticle::class,'updatepagedata']);
Route::post('/UpdateBlog', [Blogs::class,'updateblog']);

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


