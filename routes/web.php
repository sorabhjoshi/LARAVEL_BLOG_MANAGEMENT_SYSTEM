<?php

  use App\Http\Controllers\Admin\Domain;
use App\Http\Controllers\Admin\Languages;
use App\Http\Controllers\mailcontroller;
use App\Http\Controllers\Admin\Menulist;
use App\Models\admin\department;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Blogs;
use App\Http\Controllers\Admin\companydatas;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\Admin\Datatable;
use App\Http\Controllers\Admin\Modules;
use App\Http\Controllers\Admin\Newsarticle;
use App\Http\Controllers\Admin\Register;
// use App\Http\Controllers\ContactController;

use App\Http\Controllers\Frontend\blogfront;
use App\Http\Controllers\Frontend\Home;
use App\Http\Controllers\Frontend\Newsfront;
use App\Http\Controllers\Frontend\Pages;
// use App\Models\Admin\Pages;
  
// use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
Route::post('/contact', [mailcontroller::class, 'sendContactForm'])->name('contact.send');
Route::get('/contact', [mailcontroller::class, 'sendContactForm'])->name('contact.send');

Route::get('/', function () {
    return view('welcome');
});
  
Auth::routes();

// Route::view('Forbidden-403', 'Blogbackend.error')->name('errors');

// Route::get('/home', [HomeController::class, 'index'])->name('home');
  

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class)->middleware('role:Admin');
    Route::resource('products', ProductController::class)->middleware('role:Admin|Manager');
    
   
    Route::get('Admin/Dashboard', [Blogs::class, 'dashboard'])->name('home');
    Route::get('/Admin/Myprofile', [Register::class, 'myprofile'])->name('Myprofile');

    // Delete routes
    
    Route::get('/Deletedomain/{id}', [Domain::class, 'delete']);
    Route::get('/Deletemenutable/{id}', [Menulist::class, 'delete'])->name('delete.menu');
    Route::get('/Deleteuser/{id}', [UserController::class, 'deleteuser'])->middleware('role:Admin');
    Route::get('/Deleteblog/{id}', [Blogs::class, 'deleteblog'])->name('DeleteBlog')->middleware('role:Admin|Blog-team');
    Route::get('/DeleteNews/{id}', [Newsarticle::class, 'deletenews'])->middleware('role:Admin|News-team');
    Route::get('/Deleteblogcat/{id}', [Blogs::class, 'deleteblogcat'])->name('DeleteBlogCat')->middleware('role:Admin|Blog-team');
    Route::get('/Deletenewscat/{id}', [Newsarticle::class, 'deletenewscat'])->middleware('role:Admin|News-team');
    Route::get('/Deletepages/{id}', [Newsarticle::class, 'deletepages'])->middleware('role:Admin');
    Route::get('/Deletecompany/{id}', [companydatas::class, 'deletecompany'])->middleware('role:Admin');
    Route::get('Admin/Modules/DeleteModule/{id}', [Modules::class, 'DeleteModule'])->middleware('role:Admin');

    // Add routes
    
    // Route for getting the department by ID
Route::get('/getDepartmentById/{id}', [\App\Http\Controllers\admin\department::class, 'getDepartmentById']);

// Route for updating the department
Route::post('/updateDepartment', [\App\Http\Controllers\admin\department::class, 'updateDepartment']);

    Route::post('/AddDepartmentAjax', [\App\Http\Controllers\admin\department::class, 'store'])->name('AddDepartmentAjax');

    Route::post('/addlanguageAjax', [Languages::class, 'store'])->name('addlanguageAjax');

    Route::view('Admin/Domain/Add_Domain', 'Blogbackend.Utils.Adddomain')->name('add_domain')->middleware('role:Admin');
    Route::get('Admin/Menu/Addmenu/{id}', [Menulist::class, 'Addmenubar'])->name('Addmenu')->middleware('role:Admin');
    Route::post('Admin/addmenutabledata', [Menulist::class, 'store'])->name('addmenutabledata')->middleware('role:Admin');
    Route::view('/Addmenutable', 'Blogbackend.Utils.Addmenutable')->name('addmenutable')->middleware('role:Admin');
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
    
    Route::get('/Editlanguage/{id}', [Languages::class, 'edit'])->middleware('role:Admin');
    Route::get('/Editdomain/{id}', [Domain::class, 'edit'])->middleware('role:Admin');
    Route::post('/Editdomaindata', [Domain::class, 'update'])->middleware('role:Admin');
    Route::post('/AddDomain', [Domain::class, 'store'])->middleware('role:Admin');
    Route::get('/roles/access/{roleId}', [RoleController::class, 'access'])->middleware('role:Admin')->name('roles.access');
    Route::post('/roles/update-access/{roleId}', [RoleController::class, 'updateAccess'])->middleware('role:Admin')->name('roles.updateAccess');
    Route::put('/updatemenu/{id}', [Menulist::class, 'update'])->name('updatemenu');
    Route::post('/updatejsondata', [Menulist::class, 'updatejsondata']);
    Route::get('/Editmenutable/{id}', [Menulist::class, 'edit'])->middleware('role:Admin');
    Route::get('Admin/Modules/EditModule/{id}', [Modules::class, 'editmodule'])->name('editmodule')->middleware('role:Admin');
    Route::get('Modules/AddPermissions/{id}', 'ModulesController@addPermissions')->name('addpermissions')->middleware('role:Admin');
    Route::get('/Editcompany/{id}', [companydatas::class, 'editcompany'])->middleware('role:Admin');
    Route::get('/Editpages/{id}', [Newsarticle::class, 'editpages'])->middleware('role:Admin');
    Route::get('/Editnewscat/{id}', [Newsarticle::class, 'editnewscat'])->middleware('role:Admin|News-team');
    Route::get('/Editblogcat/{id}', [Blogs::class, 'editblogcat'])->name('EditBlogCat')->middleware('role:Admin|Blog-team');
    Route::get('/Edituser/{id}', [UserController::class, 'editUser'])->middleware('role:Admin');
    Route::get('/Editblog/{id}', [Blogs::class, 'editblog'])->name('EditBlog')->middleware('role:Admin|Blog-team');
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
    
    Route::get('blog-categories', [Blogs::class, 'blogcat'])->name('BlogCategoryList');
    Route::get('blogsssssss', [Blogs::class, 'BlogList'])->name('BlogList');
    
    Route::post('/addlanguageAjax', [Languages::class, 'store'])->name('addlanguageAjax');
    Route::put('/editlanguageAjax/{id}', [Languages::class, 'update'])->name('editlanguageAjax');
    Route::delete('/deletelanguageAjax/{id}', [Languages::class, 'destroy'])->name('deletelanguageAjax');
    
    Route::post('/GetDepartmentAjax', [Datatable::class, 'GetDepartmentAjax']);
    Route::post('/getlanguagesAjax', [Datatable::class, 'getlanguagesAjax']);
    Route::post('/menudatatable', [Datatable::class, 'menudatatable'])->name('menudatatable');
    Route::post('/getmoduleAjax', [Datatable::class, 'getmoduleAjax']);
    Route::post('/saveCompanyAddress', [Datatable::class, 'savecompanyaddress']);
    Route::post('/deleteAddress', [Datatable::class, 'deleteAddress']);
    Route::post('/getAddressData', [Datatable::class, 'getaddressdata']);
    Route::post('/GetDomainAjax', [Datatable::class, 'GetDomainAjax']);
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

    Route::get('/Admin/languages', function () {
        return view('Blogbackend.languages');
    })->name('languages');

    Route::get('/Admin/Domain', function () {
        return view('Blogbackend.Domain');
    })->name('domain');

    Route::get('/Admin/Modules', function () {
        return view('Blogbackend.Modules');
    })->name('Modules');

    Route::get('Admin/Menulist', function(){
        return view('Blogbackend.Menu');
    })->name('menulist');

    Route::get('/Admin/Users', function () {
        return view('Blogbackend.Users');
    })->name('Users');

    Route::get('/Admin/Department', function () {
        return view('Blogbackend.Department');
    })->name('Department')->middleware(middleware: 'role:Admin');

    Route::get('/Admin/Blog', [Blogs::class, 'showblogs'])->name('Blog')->middleware('role:Admin|Blog-team');

    Route::get('/Admin/BlogCat', [Blogs::class, 'showcat'])->name('Blogscat')->middleware('role:Admin|Blog-team');

    Route::get('/Admin/News', function () {
        return view('Blogbackend.News');
    })->name('Newsarticle')->middleware('role:Admin|News-team');

    Route::get('/Admin/NewsCat', function () {
        return view('Blogbackend.NewsCat');
    })->name('Newscat')->middleware('role:Admin|News-team');

    Route::get('/Admin/Pages', function () {
        return view('Blogbackend.Pages');
    })->name('Page');

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

Route::get('/News', [Newsfront::class, 'shownews'])->name('News');

Route::get('/Blogs', [blogfront::class, 'showblog'])->name('Blogs');

Route::get('News/{article}', [Newsfront::class, 'showsinglenews']);

Route::get('Blog/{article}', [blogfront::class, 'showsingleblog']);

Route::get('Blog/Category/{article}', [blogfront::class, 'showcategory']);

Route::get('News/Category/{article}', [Newsfront::class, 'showcategory']);


Route::get('/Page/{pages}', [Pages::class, 'showpage']); 

Route::get('/loadmodules', [RoleController::class, 'loadmodules'])->name('loadmodules');
Route::get('/ajaxblogs', [blogfront::class, 'loadMoreBlogs'])->name('ajaxblogs');
Route::get('/ajaxnews', [Newsfront::class, 'loadMoreNews'])->name('ajaxnews');
Route::get('/load-more-news', [Newsfront::class, 'loadMoreNewscat'])->name('loadMoreNewsCat');
Route::get('/load-more-blogs', [blogfront::class, 'loadMoreblogscat'])->name('loadMoreBlogscat');
