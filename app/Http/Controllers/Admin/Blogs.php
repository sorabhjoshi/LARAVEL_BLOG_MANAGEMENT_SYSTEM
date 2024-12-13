<?php
namespace App\Http\Controllers\Admin;
use App\Models\Admin\Blog;
use App\Models\Admin\Blogcat;
use App\Models\Admin\News;
use App\Models\Admin\Register_model;
use App\Models\Admin\User;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class Blogs extends Controller
{
    public function addblogdata(Request $request)
{
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login')->withErrors('Please login to add a blog');
    }

    $request->validate([
        'author_name' => 'required|string|max:255',
        'title' => 'required|string|max:255',
        'image' => 'required',
        'content' => 'required|string',
        'category' => 'required|string',
    ]);

    $imagePath = null;
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $imagePath = 'images/' . $imageName;
        $image->move(public_path('images'), $imageName);
    }

    $slug = Str::slug($request->input('title'));
    $existingSlugCount = Blog::where('slug', $slug)->count();
    if ($existingSlugCount > 0) {
        $slug = $slug . '-' . time();
    }

    Blog::create([
        'authorname' => $request->input('author_name'),
        'title' => $request->input('title'),
        'image' => $imagePath,
        'description' => $request->input('content'),
        'category' => $request->input('category'),
        'slug' => $slug,
        'userid' => $user->id,  // Store the user ID here
    ]);

    return redirect()->route('Blog')->with('success', 'User updated successfully!');
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
         $userdata = Blog::find($id);
         $Catdata = Blogcat::select('categorytitle', 'id')->get();
         return view('Blogbackend.Utils.Editblog', ['userdata' => $userdata,'Catdata'=> $Catdata]);
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

public function dashboard(){
    $category= Blog::getBlogCategories();
    $users = Register_model::count();
    $news = News::count();
    $blogs = Blog::count();
    return view('Blogbackend.Home', [
        'category' => $category,
        'users' => $users,
        'news' => $news,
        'blogs' => $blogs,
    ]);
}

public function addblog(Request $request)
{
    $Catdata = Blogcat::select('categorytitle', 'id')->get();
    return view('Blogbackend/Utils/AddBlog', compact('Catdata'));
}


}
