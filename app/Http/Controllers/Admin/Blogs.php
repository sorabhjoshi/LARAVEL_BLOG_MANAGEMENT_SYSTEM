<?php
namespace App\Http\Controllers\Admin;
use App\Models\Admin\Blog;
use App\Models\Admin\Blogcat;
use App\Models\Admin\Designation;
use App\Models\Admin\Domains;
use App\Models\Admin\Language;
use App\Models\Admin\Menu;
use App\Models\Admin\News;
use App\Models\Admin\Register_model;
use App\Models\Admin\Status;
use App\Models\Admin\User;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class Blogs extends Controller
{
    public function addblogdata(Request $request)
{
    $userdata = \Illuminate\Support\Facades\Auth::user();
    
    if (!$userdata) {
        return redirect()->route('login')->withErrors('Please login to add a blog');
    }

    // Validate the incoming request
    $request->validate([
        'author_name' => 'required|string|max:255',
        'title' => 'required|string|max:255',
        'image' => 'required|image|max:2048', // Added image validation (e.g., size limit, type)
        'content' => 'required|string',
        'category' => 'required|string',
        'Domain' => 'required|string',
        'Languages' => 'required|string'
    ]);
    
    $imagePath = null;
    if ($request->hasFile('image')) {
        // Handle the image upload
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $imagePath = 'images/' . $imageName;
        $image->move(public_path('images'), $imageName);
    }

    // Generate a unique slug based on the title
    $slug = Str::slug($request->input('title'));
    $existingSlugCount = Blog::where('slug', $slug)->count();
    if ($existingSlugCount > 0) {
        $slug = $slug . '-' . time(); 
    }
    
//    dd($request->input('Domain'));
    Blog::create([
        'authorname' => $request->input('author_name'),
        'title' => $request->input('title'),
        'image' => $imagePath,
        'description' => $request->input('content'),
        'category' => $request->input('category'),
        'slug' => $slug,
        'domain' => $request->input('Domain'),
        'user_id' => $userdata->id,  
        'language' => $request->input('Languages'),
    ]);

    // dd(\DB::getQueryLog());

    return redirect()->route('Blog')->with('success', 'Blog added successfully!');
}




public function deleteblog($id){
    $userdata = Blog::find($id);
    if ($userdata->delete()) {
        return redirect()->route('Blog')->with('success', 'User updated successfully!');
    } else {
        return redirect()->back()->with('error', 'Blog not found.');
    }
    
}
public function editblog($id){
         $lang = Language::all();
         $domain = Domains::all();
         $userdata = Blog::find($id);
         $Catdata = Blogcat::select('categorytitle', 'id')->get();
         return view('Blogbackend.Utils.Editblog', ['userdata' => $userdata,'Catdata'=> $Catdata,'domain'=>$domain,'lang'=>$lang]);
}

public function updateblog(Request $request)
{
    // $user = session('user');
    $request->validate([
        'id' => 'required',
        'author_name' => 'required|string|max:255',
        'title' => 'required|string|max:255',
        'image' => 'nullable|image',
        'content' => 'required|string',
        'category' => 'required|string',
        'Domain' => 'required|string',
        'Languages' => 'required|string'
    ]);

    $userdata = Blog::find($request->input('id'));
    if (!$userdata) {
        return redirect()->back()->withErrors('Blog not found!');
    }

    $imagePath = $userdata->image; // Retain old image if not updated
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $imagePath = 'images/' . $imageName;
        $image->move(public_path('images'), $imageName);
    }

    $slug = Str::slug($request->input('title'));
    $existingSlugCount = Blog::where('slug', $slug)->where('id', '!=', $userdata->id)->count();
    if ($existingSlugCount > 0) {
        $slug = $slug . '-' . time();
    }

    $userdata->authorname = $request->input('author_name');
    $userdata->title = $request->input('title');
    $userdata->image = $imagePath;
    $userdata->description = $request->input('content');
    $userdata->category = $request->input('category');
    $userdata->slug = $slug;
    // $userdata->userid = $user->id;
    $userdata->domain= $request->input('Domain');
    $userdata->language= $request->input('Languages');

    $userdata->save(); 

    return redirect()->route('Blog')->with('success', 'Blog updated successfully!');
}


public function addblogcat(Request $request)
{

    $request->validate([
        'categorytitle' => 'required|string|max:255',
        'seotitle' => 'required|string|max:255',
        'metakeywords' => 'required',
        'metadescription' => 'required|string',
    ]);

    Blogcat::create([
        'categorytitle' => $request->input('categorytitle'),
        'seotitle' => $request->input('seotitle'),
        'metakeywords' =>  $request->input('metakeywords'),
        'metadescription' => $request->input('metadescription')
    ]);

    return redirect()->route('BlogCat')->with('success', 'User updated successfully!');
}

public function editblogcat($id){
    $userdata = Blogcat::find($id);
    return view('Blogbackend.Utils.Editblogcat', ['userdata' => $userdata]);
}

public function updateblogcat(Request $request)
{
    // $user = session('user');
    $request->validate([
        'id' => 'required',
        'categorytitle' => 'required|string|max:255',
        'seotitle' => 'required|string|max:255',
        'metakeywords' => 'required',
        'metadescription' => 'required|string',
    ]);

    $userdata = Blogcat::find($request->input('id'));
    $userdata->categorytitle = $request->input('categorytitle');
    $userdata->seotitle = $request->input('seotitle');
    $userdata->metakeywords = $request->input('metakeywords');
    $userdata->metadescription = $request->input('metadescription');
    // $userdata->userid = $user->id;

    $userdata->save(); 

    return redirect()->route('BlogCat')->with('success', 'Blog updated successfully!');
}

public function deleteblogcat($id){
    $userdata = Blogcat::find($id);
    if ($userdata->delete()) {
        return redirect()->route('BlogCat')->with('success', 'User updated successfully!');
    } else {
        return redirect()->back()->with('error', 'Blog not found.');
    }
    
}

public function dashboard()
{
     
    $category = Blogcat::withCount('blogs')->get();
    $users = Register_model::count();
    $news = News::count();
    $blogs = Blog::count();
    
    return view('Blogbackend.Home', compact('category', 'users', 'news', 'blogs'));
}


public function addblog(Request $request)
{
    // dd(auth()->user());
    $lang = Language::all();
    $domain = Domains::all();
    $Catdata = Blogcat::select('categorytitle', 'id')->get();
    return view('Blogbackend/Utils/AddBlog', compact('Catdata','domain','lang'));
}

public function showcat(){
    
    $userdata = Blogcat::withCount('blogs' )->paginate(2);
    // dd($userdata);
    return view('Blogbackend/BlogCat', ['userdata' => $userdata]);
}
public function blogcat(Request $request)
{
   
    $query = Blogcat::query();

    if ($request->has('startDate') && $request->startDate != '') {
        $query->whereDate('created_at', '>=', $request->startDate);
    }
    if ($request->has('endDate') && $request->endDate != '') {
        $query->whereDate('created_at', '<=', $request->endDate);
    }

    
    if ($request->has('search') && $request->search != '') {
        if ($request->search == 'Category') {
            $query->where('categorytitle', 'like', '%' . $request->searchValue . '%');
        } elseif ($request->search == 'Name') {
            $query->where('seotitle', 'like', '%' . $request->searchValue . '%');
        }
    }

    
    $userdata = $query->paginate(10);

    return view('Blogbackend.BlogCat', compact('userdata'));
}

public function showblogs()
{
    // Fetch all status names
    // $statusnames = Status::all();

    // Fetch blogs with relationships and apply pagination
    $designations = Designation::all(); 
    $blogdata = Blog::with(['categories', 'domainrel', 'langrel', 'statuss','approval'])->paginate(2);
    $designationid = \App\Models\User::where('id', session('user_id'))->pluck('designation')->first();

    // Pass data to the view
    return view('Blogbackend.Blog', [
        'userdata' => $blogdata,
        'designationid'=> $designationid,
        'designations' => $designations
    ]);
}


public function BlogList(Request $request)
{
   
    $query = Blog::query();

    if ($request->has('startDate') && $request->startDate != '') {
        $query->whereDate('created_at', '>=', $request->startDate);
    }
    if ($request->has('endDate') && $request->endDate != '') {
        $query->whereDate('created_at', '<=', $request->endDate);
    }

    
    if ($request->has('search') && $request->search != '') {
        if ($request->search == 'Category') {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categorytitle', 'like', '%' . $request->searchValue . '%');
            });
        } elseif ($request->search == 'Name') {
            $query->where('title', 'like', '%' . $request->searchValue . '%');
        }
    }

    $statusnames = Status::all();
    $userdata = $query->with('categories')->paginate(2);

    return view('Blogbackend.Blog', compact('userdata','statusnames'));
}

}
