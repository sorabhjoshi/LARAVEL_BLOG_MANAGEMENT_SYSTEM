<?php

namespace App\Http\Controllers\Admin;
use App\Models\Admin\News;
use App\Models\Admin\Newscat;
use App\Models\Admin\Pages;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class Newsarticle extends Controller
{
public function addnewsdata(Request $request)
    {
       
    
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
        $existingSlugCount = News::where('slug', $slug)->count();
        if ($existingSlugCount > 0) {
            $slug = $slug . '-' . time();
        }
        $user = Auth::user();

        News::create([
            'authorname' => $request->input('author_name'),
            'title' => $request->input('title'),
            'image' => $imagePath,
            'description' => $request->input('content'),
            'category' => $request->input('category'),
            'slug' => $slug,
            'user_id' => $user->id, 
        ]);
    
        return redirect()->route('Newsarticle')->with('success', 'Blog updated successfully!');
}

public function editnews($id){
        $userdata = News::find($id);
        $Catdata = Newscat::select('categorytitle','id')->get();
        return view('Blogbackend.Utils.Editnews', ['userdata' => $userdata,'Catdata'=>$Catdata]);
}

public function updatenews(Request $request)
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

    $userdata = News::find($request->input('id'));
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
    $existingSlugCount = News::where('slug', $slug)->where('id', '!=', $userdata->id)->count();
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

    return redirect()->route('Newsarticle')->with('success', 'Blog updated successfully!');
}

public function deletenews($id){
    $userdata = News::find($id);
    if ($userdata->delete()) {
        return redirect()->route('Newsarticle')->with('success', 'User updated successfully!');
    } else {
        return redirect()->back()->with('error', 'Blog not found.');
    }
    
}
public function addnewscatdata(Request $request)
{

    $request->validate([
        'categorytitle' => 'required|string|max:255',
        'seotitle' => 'required|string|max:255',
        'metakeywords' => 'required',
        'metadescription' => 'required|string',
    ]);

    Newscat::create([
        'categorytitle' => $request->input('categorytitle'),
        'seotitle' => $request->input('seotitle'),
        'metakeywords' =>  $request->input('metakeywords'),
        'metadescription' => $request->input('metadescription')
    ]);

    return redirect()->route('NewsCat')->with('success', 'User updated successfully!');
}
public function editnewscat($id){
    $userdata = Newscat::find($id);
    return view('Blogbackend.Utils.Editnewscat', ['userdata' => $userdata]);
}
public function updatenewscat(Request $request)
{
    // $user = session('user');
    $request->validate([
        'id' => 'required',
        'categorytitle' => 'required|string|max:255',
        'seotitle' => 'required|string|max:255',
        'metakeywords' => 'required',
        'metadescription' => 'required|string',
    ]);

    $userdata = Newscat::find($request->input('id'));
    $userdata->categorytitle = $request->input('categorytitle');
    $userdata->seotitle = $request->input('seotitle');
    $userdata->metakeywords = $request->input('metakeywords');
    $userdata->metadescription = $request->input('metadescription');
    // $userdata->userid = $user->id;

    $userdata->save(); 

    return redirect()->route('NewsCat')->with('success', 'Blog updated successfully!');
}
public function deletenewscat($id){
    $userdata = Newscat::find($id);
    if ($userdata->delete()) {
        return redirect()->route('NewsCat')->with('success', 'User updated successfully!');
    } else {
        return redirect()->back()->with('error', 'Blog not found.');
    }
    
}
public function addpagedata(Request $request)
{

    $request->validate([
        'authorname' => 'required|string|max:255',
        'title' => 'required|string|max:255',
        'description' => 'required',
    ]);
    $slug = Str::slug($request->input('title'));
        $existingSlugCount = News::where('slug', $slug)->count();
        if ($existingSlugCount > 0) {
            $slug = $slug . '-' . time();
        }
    $user = Auth::user();

    Pages::create([
        'author' => $request->input('authorname'),
        'title' => $request->input('title'),
        'description' =>  $request->input('description'),
        'slug' => $slug,
        'userid' => $user->id,  //
    ]);

    return redirect()->route('Pages')->with('success', 'User updated successfully!');
}
public function editpages($id){
    $userdata = Pages::find($id);
    return view('Blogbackend.Utils.Editpages', ['userdata' => $userdata]);
}

public function deletepages($id){
        $pagedata=Pages::find($id);
        if ($pagedata->delete()) {
           return redirect()->route('Pages');
        }
}
public function updatepagedata(Request $request)
{
    // $user = session('user');
    $request->validate([
        'id' => 'required',
        'authorname' => 'required|string|max:255',
        'title' => 'required|string|max:255',
        'description' => 'required',
    ]);

    $slug = Str::slug($request->input('title'));
    $existingSlugCount = News::where('slug', $slug)->count();
    if ($existingSlugCount > 0) {
        $slug = $slug . '-' . time();
    }
    $userdata= Pages::find($request->input('id'));
    
        $userdata->author = $request->input('authorname');
        $userdata->title = $request->input('title');
        $userdata->description =  $request->input('description');
        $userdata->slug = $slug ;//
        if ($userdata->save() ) {
            return redirect()->route('Pages')->with('success', 'User updated successfully!');
        }else{
            return redirect()->back()->withErrors('error', 'Page update error!');
        }
}
public function addnews(){
    $Catdata = Newscat::select('categorytitle','id')->get();
  return view('Blogbackend/Utils/AddNews', compact('Catdata'));
}

}
