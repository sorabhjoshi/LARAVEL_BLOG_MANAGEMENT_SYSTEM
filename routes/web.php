<?php

  use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Blogs;
use App\Http\Controllers\Admin\companydatas;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\Admin\Datatable;
use App\Http\Controllers\Admin\Modules;
use App\Http\Controllers\Admin\Newsarticle;
use App\Http\Controllers\Admin\Register;
use App\Http\Controllers\ContactController;

use App\Http\Controllers\Frontend\blogfront;
use App\Http\Controllers\Frontend\Home;
use App\Http\Controllers\Frontend\Newsfront;
use App\Models\Admin\Pages;
  
// use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
   
Route::get('/', function () {
    return view('welcome');
});
  
Auth::routes();

// Route::view('Forbidden-403', 'Blogbackend.error')->name('errors');

// Route::get('/home', [HomeController::class, 'index'])->name('home');
  

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class)->middleware('role:Admin');
    Route::resource('users', UserController::class)->middleware('role:Admin');
    Route::resource('products', ProductController::class)->middleware('role:Admin|Manager');

    Route::get('/Dashboard', [Blogs::class, 'dashboard'])->name('home');
    Route::get('/Admin/Myprofile', [Register::class, 'myprofile'])->name('Myprofile');

    // Delete routes
    Route::get('/Deleteuser/{id}', [UserController::class, 'deleteuser'])->middleware('role:Admin');
    Route::get('/Deleteblog/{id}', [Blogs::class, 'deleteblog'])->middleware('role:Admin|Blog-team');
    Route::get('/DeleteNews/{id}', [Newsarticle::class, 'deletenews'])->middleware('role:Admin|News-team');
    Route::get('/Deleteblogcat/{id}', [Blogs::class, 'deleteblogcat'])->middleware('role:Admin|Blog-team');
    Route::get('/Deletenewscat/{id}', [Newsarticle::class, 'deletenewscat'])->middleware('role:Admin|News-team');
    Route::get('/Deletepages/{id}', [Newsarticle::class, 'deletepages'])->middleware('role:Admin');
    Route::get('/Deletecompany/{id}', [companydatas::class, 'deletecompany'])->middleware('role:Admin');
    Route::get('Admin/Modules/DeleteModule/{id}', [Modules::class, 'DeleteModule'])->middleware('role:Admin');

    // Add routes
    Route::get('Admin/Addmodule', [Modules::class, 'Addmodule'])->name('addmodule')->middleware('role:Admin');
    Route::view('/AddCompany', 'Blogbackend.Utils.AddCompany')->name('AddCompany')->middleware('role:Admin');
    Route::view('Admin/Pages/AddPage', 'Blogbackend.Utils.AddPage')->name('addpages')->middleware('role:Admin');
    Route::view('Admin/NewsCat/AddNewCat', 'Blogbackend.Utils.AddNewsCat')->name('AddNewCat')->middleware('role:Admin|News-team');
    Route::view('Admin/BlogCat/AddBlogCat', 'Blogbackend.Utils.AddBlogCat')->name('AddBlogCat')->middleware('role:Admin|Blog-team');
    Route::view('Admin/News/AddNews', 'Blogbackend.Utils.AddNews')->name('AddNews')->middleware('role:Admin|News-team');
    Route::get('/AddNews', [Newsarticle::class, 'addnews'])->name('AddNews')->middleware('role:Admin|News-team');
    Route::get('/AddBlog', [Blogs::class, 'addblog'])->name('addblog')->middleware('role:Admin|Blog-team');
    Route::view('/EditUser', 'Blogbackend.Utils.Edituser')->middleware('role:Admin');

    // Edit and update routes
    Route::get('Admin/Modules/EditModule/{id}', [Modules::class, 'editmodule'])->name('editmodule')->middleware('role:Admin');
    Route::get('Modules/AddPermissions/{id}', 'ModulesController@addPermissions')->name('addpermissions')->middleware('role:Admin');
    Route::get('/Editcompany/{id}', [companydatas::class, 'editcompany'])->middleware('role:Admin');
    Route::get('/Editpages/{id}', [Newsarticle::class, 'editpages'])->middleware('role:Admin');
    Route::get('/Editnewscat/{id}', [Newsarticle::class, 'editnewscat'])->middleware('role:Admin|News-team');
    Route::get('/Editblogcat/{id}', [Blogs::class, 'editblogcat'])->middleware('role:Admin|Blog-team');
    Route::get('/Edituser/{id}', [UserController::class, 'editUser'])->middleware('role:Admin');
    Route::get('/Editblog/{id}', [Blogs::class, 'editblog'])->middleware('role:Admin|Blog-team');
    Route::view('/Editblog', 'Blogbackend.Utils.Editblog')->name('Editblog')->middleware('role:Admin|Blog-team');
    Route::get('/EditNews/{id}', [Newsarticle::class, 'editnews'])->middleware('role:Admin|News-team');
    Route::post('/AddNews', [Newsarticle::class, 'addnewsdata'])->middleware('role:Admin|News-team');
    Route::post('/AddBlog', [Blogs::class, 'addblogdata'])->middleware('role:Admin|Blog-team');
    Route::post('/AddBlogCat', [Blogs::class, 'addblogcat'])->middleware('role:Admin|Blog-team');
    Route::post('/UpdateBlogCat', [Blogs::class, 'updateblogcat'])->middleware('role:Admin|Blog-team');
    Route::post('/AddNewsCatdata', [Newsarticle::class, 'addnewscatdata'])->middleware('role:Admin|News-team');
    Route::post('/AddPageData', [Newsarticle::class, 'addpagedata'])->middleware('role:Admin');
    Route::post('/AddCompanyData', [companydatas::class, 'addcompanydata'])->middleware('role:Admin');
    Route::post('/UpdateNewsCat', [Newsarticle::class, 'updatenewscat'])->middleware('role:Admin|News-team');
    Route::post('/UpdateCompanyData', [companydatas::class, 'updatecompanydata'])->middleware('role:Admin');
    Route::post('Admin/modulesstore', [Modules::class, 'store'])->name('modulesstore')->middleware('role:Admin');
    Route::post('Admin/moduleedit', [Modules::class, 'storeedit'])->name('moduleedit')->middleware('role:Admin');
    // Ajax routes
    Route::post('/getmoduleAjax', [Datatable::class, 'getmoduleAjax']);
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
    Route::post('/UpdateNews', [Newsarticle::class, 'updatenews'])->middleware('role:Admin|News-team');
    Route::post('/UpdatePageData', [Newsarticle::class, 'updatepagedata'])->middleware('role:Admin');
    Route::post('/UpdateBlog', [Blogs::class, 'updateblog'])->middleware('role:Admin|Blog-team');
    Route::post('/storepermission', [Datatable::class, 'savePermissions'])->name('storepermission')->middleware('role:Admin');
    Route::post('/show-permissions', [Datatable::class, 'ShowPermissions'])->name('ShowPermissions')->middleware('role:Admin');
    Route::post('/deletepermission', [Datatable::class, 'deletePermission'])->name('deletePermission')->middleware('role:Admin');

    // Basic routes of pages
    Route::get('/Admin/Modules', function () {
        return view('Blogbackend.Modules');
    })->name('Modules');

    Route::get('/Admin/Users', function () {
        return view('Blogbackend.Users');
    })->name('Users');

    Route::get('/Admin/Blog', function () {
        return view('Blogbackend.Blog');
    })->name('Blog')->middleware('role:Admin|Blog-team');

    Route::get('/Admin/BlogCat', function () {
        return view('Blogbackend.BlogCat');
    })->name('BlogCat')->middleware('role:Admin|Blog-team');

    Route::get('/Admin/News', function () {
        return view('Blogbackend.News');
    })->name('Newsarticle')->middleware('role:Admin|News-team');

    Route::get('/Admin/NewsCat', function () {
        return view('Blogbackend.NewsCat');
    })->name('NewsCat')->middleware('role:Admin|News-team');

    Route::get('/Admin/Pages', function () {
        return view('Blogbackend.Pages');
    })->name('Pages');

    Route::get('/Admin/Company', function () {
        return view('Blogbackend.CompanyProfile');
    })->name('Company');

    Route::get('/Admin/Logout', [Register::class, 'logout'])->name('Logout')->middleware('role:Admin|User');
});














// Frontend routes (no auth required)
Route::get('/dashboard', [Home::class, 'dashboard'])->name('Dashboardfront');
Route::get('/frontend', [Home::class, 'dashboard'])->name('frontend');

Route::get('/About', function () {
    return view('Frontend.About');
})->name('About');

Route::get('/ContactUs', function () {
    return view('Frontend.Contact');
})->name('Contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
Route::get('/News', [Newsfront::class, 'shownews'])->name('News');

Route::get('/Blogs', [blogfront::class, 'showblog'])->name('Blogs');

Route::get('News/{article}', [Newsfront::class, 'showsinglenews']);

Route::get('Blog/{article}', [blogfront::class, 'showsingleblog']);

Route::get('Blog/Category/{article}', [blogfront::class, 'showcategory']);

Route::get('News/Category/{article}', [Newsfront::class, 'showcategory']);

Route::get('/Page/{pages}', [Pages::class, 'showpage']);

Route::get('/ajaxblogs', [blogfront::class, 'loadMoreBlogs'])->name('ajaxblogs');
Route::get('/ajaxnews', [Newsfront::class, 'loadMoreNews'])->name('ajaxnews');