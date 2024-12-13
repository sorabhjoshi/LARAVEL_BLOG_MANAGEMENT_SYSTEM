<?php
  
use App\Http\Controllers\Admin\Blogs;
use App\Http\Controllers\Admin\companydatas;
use App\Http\Controllers\Admin\Datatable;
use App\Http\Controllers\Admin\Newsarticle;
use App\Http\Controllers\Admin\Register;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Frontend\blogfront;
use App\Http\Controllers\Frontend\Home;
use App\Http\Controllers\Frontend\Newsfront;
use Illuminate\Support\Facades\Route;
  
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
   
Route::get('/', function () {
    return view('welcome');
});
  
Auth::routes();
  
Route::get('/home', [HomeController::class, 'index'])->name('home');
  
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
    Route::resource('roles', RoleController::class);

    Route::resource('users', UserController::class);

    Route::resource('products', ProductController::class);


    Route::view('/home', 'home')->name('home');
    // Route::get('/Dashboard', [Blogs::class, 'dashboard'])->name('home');
    Route::get('/Admin/Myprofile', function () {
        return view('Blogbackend.Myprofile');
    })->name('Myprofile');
 
    // Delete routes
    Route::get('/Deleteuser/{id}', [UserController::class, 'deleteuser']);
    Route::get('/Deleteblog/{id}', [Blogs::class, 'deleteblog']);
    Route::get('/DeleteNews/{id}', [Newsarticle::class, 'deletenews']);
    Route::get('/Deleteblogcat/{id}', [Blogs::class, 'deleteblogcat']);
    Route::get('/Deletenewscat/{id}', [Newsarticle::class, 'deletenewscat']);
    Route::get('/Deletepages/{id}', [Newsarticle::class, 'deletepages']);
    Route::get('/Deletecompany/{id}', [companydatas::class, 'deletecompany']);

    // Add routes
    Route::view('/AddCompany', 'Blogbackend.Utils.AddCompany')->name('AddCompany');
    Route::view('Admin/Pages/AddPage', 'Blogbackend.Utils.AddPage')->name('addpages');
    Route::view('Admin/NewsCat/AddNewCat', 'Blogbackend.Utils.AddNewsCat')->name('AddNewCat');
    Route::view('Admin/BlogCat/AddBlogCat', 'Blogbackend.Utils.AddBlogCat')->name('AddBlogCat');
    Route::view('Admin/News/AddNews', 'Blogbackend.Utils.AddNews')->name('AddNews');
    Route::get('/AddNews', [Newsarticle::class, 'addnews'])->name('AddNews');
    Route::get('/AddBlog', [Blogs::class, 'addblog'])->name('addblog');
    // Route::view('/AddBlog', 'Blogbackend.Utils.AddBlog')->name('AddBlog');
    Route::view('/EditUser', 'Blogbackend.Utils.Edituser');

    // Edit and update routes
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

    // Ajax routes
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

    // Basic routes of pages
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
    })->name('Newsarticle');

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