<?php
use App\Http\Controllers\Admin\companydatas;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\Register;
use App\Http\Controllers\Admin\Blogs;
use App\Http\Controllers\Admin\Newsarticle;
use App\Http\Controllers\Admin\Datatable;
use App\Http\Controllers\Frontend\Home;
use App\Models\Admin\Blogcat;
use App\Models\Admin\Newscat;
use Illuminate\Support\Facades\Route;

#auth routes
Route::get('/register', function () {
    return view('Register');
});

Route::post('/register', [Register::class, 'registers']);
Route::get('/login', function () {
    return view('Login');
})->name('login');

Route::post('/login', [Register::class, 'login']);

Route::get('/Dashboard', [Blogs::class, 'dashboard'])->name('home');

Route::get('/Admin/Myprofile', function () {
    return view('Blogbackend.Myprofile');
})->name('Myprofile');

#delete routes
Route::get('/Deleteuser/{id}', [UserController::class, 'deleteuser']);
Route::get('/Deleteblog/{id}', [Blogs::class, 'deleteblog']);
Route::get('/DeleteNews/{id}', [Newsarticle::class, 'deletenews']);
Route::get('/Deleteblogcat/{id}', [Blogs::class, 'deleteblogcat']);
Route::get('/Deletenewscat/{id}', [Newsarticle::class, 'deletenewscat']);
Route::get('/Deletepages/{id}', [Newsarticle::class, 'deletepages']);
Route::get('/Deletecompany/{id}', [companydatas::class, 'deletecompany']);


#add routes
Route::view('/AddCompany', 'Blogbackend.Utils.AddCompany');
Route::view('/AddPage', 'Blogbackend.Utils.AddPage');
Route::view('/AddNewsCat', 'Blogbackend.Utils.AddNewsCat');
Route::view('/AddBlogCat', 'Blogbackend.Utils.AddBlogCat');
Route::view('/AddNews', 'Blogbackend.Utils.AddNews');
Route::view('/AddBlog', 'Blogbackend.Utils.AddBlog');
Route::view('/EditUser', 'Blogbackend.Utils.Edituser');


#edit n update routes
Route::get('/Editcompany/{id}', [companydatas::class, 'editcompany']);
Route::get('/Editpages/{id}', [Newsarticle::class, 'editpages']);
Route::get('/Editnewscat/{id}', [Newsarticle::class, 'editnewscat']);
Route::get('/Editblogcat/{id}', [Blogs::class, 'editblogcat']);
Route::get('/Edituser/{id}', [UserController::class, 'editUser']);
Route::get('/Editblog/{id}', [Blogs::class, 'editblog']);
Route::view('/Editblog', 'Blogbackend.Utils.Editblog')->name('Editblog');
Route::get('/EditNews/{id}', [Newsarticle::class, 'editnews']);
Route::post('/AddNews', [Newsarticle::class, 'addnewsdata']);
Route::post('/AddBlog', [Blogs::class, 'addblogdata']);
Route::post('/AddBlogCat', [Blogs::class, 'addblogcat']);
Route::post('/UpdateBlogCat', [Blogs::class, 'updateblogcat']);
Route::post('/AddNewsCatdata', [Newsarticle::class, 'addnewscatdata']);
Route::post('/AddPageData', [Newsarticle::class, 'addpagedata']);
Route::post('/AddCompanyData', [companydatas::class, 'addcompanydata']);
Route::post('/UpdateNewsCat', [Newsarticle::class, 'updatenewscat']);
Route::post('/UpdateCompanyData', [companydatas::class, 'updatecompanydata']);

#ajax routes
Route::post('/saveCompanyAddress', [Datatable::class, 'savecompanyaddress']);
Route::post('/deleteAddress', [Datatable::class, 'deleteAddress']);
Route::post('/getAddressData', [Datatable::class, 'getaddressdata']);
Route::post('/getcomAjax', [Datatable::class, 'getcomAjax']);
Route::post('/getpagesAjax', [Datatable::class, 'getpagesAjax']);
Route::post('/getnewscatAjax', [Datatable::class, 'getnewscatAjax']);
Route::post('/getblogcatAjax', [Datatable::class, 'getblogcatAjax']);
Route::post('/getnewsAjax', [Datatable::class, 'getnewsAjax']);
Route::post('/getblogAjax', [Datatable::class, 'getblogAjax']);
Route::post('/getUsersAjax', [Datatable::class, 'getUsersAjax']);
Route::post('/updateprofile', [Register::class, 'updateprofile']);
Route::put('/updateuser/{id}', [UserController::class, 'updateuser'])->name('updateuser');
Route::post('/UpdateNews', [Newsarticle::class, 'updatenews']);

Route::post('/UpdatePageData', [Newsarticle::class, 'updatepagedata']);
Route::post('/UpdateBlog', [Blogs::class, 'updateblog']);
#basic routes of pages
Route::get('/Admin/updateprofile', function () {
    return view('Blogbackend.Updateprofile');
})->name('updateprofile');

Route::get('/Admin/Users', function () {
    return view('Blogbackend.Users');
})->name('Users');

Route::get('/Admin/Blog', function () {
    return view('Blogbackend.Blog');
})->name('Blog');

Route::get('/Admin/BlogCat', function () {
    return view('Blogbackend.BlogCat');
})->name('BlogCat');

Route::get('/Admin/News', function () {
    return view('Blogbackend.News');
})->name('News');

Route::get('/Admin/NewsCat', function () {
    return view('Blogbackend.NewsCat');
})->name('NewsCat');

Route::get('/Admin/Pages', function () {
    return view('Blogbackend.Pages');
})->name('Pages');

Route::get('/Admin/Company', function () {
    return view('Blogbackend.CompanyProfile');
})->name('Company');

Route::get('/Admin/Logout', [Register::class, 'logout'])->name('Logout');







#FRONTEND ROUTES----------------------------------------------

Route::get('/', [Home::class, 'dashboard'])->name('dashboard');



