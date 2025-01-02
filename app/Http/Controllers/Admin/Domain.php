<?php

namespace App\Http\Controllers\Admin;
// use App\Models\Domain;

use App\Http\Controllers\Controller;
use App\Models\Admin\Domains;
use Illuminate\Http\Request;

class Domain extends Controller
{
    
    public function store(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'domainname' => 'required|string|max:255',
            'companyname' => 'required|string|max:255',
            'mail_header' => 'nullable|string',
            'mail_footer' => 'nullable|string',
            'server_address' => 'nullable|string|max:255',
            'port' => 'nullable|integer',
            'authentication' => 'nullable|string|max:255',
            'username' => 'nullable|string|max:255',
            'password' => 'nullable|string|max:255',
            'tomail_id' => 'nullable|string|email|max:255',
        ]);

        Domains::create($validated);

        return redirect()->route('domain');
}

public function edit($id)
{
    $domain = Domains::find($id);
    return view('Blogbackend.Utils.editdomain', compact('domain'));
}
public function update( Request $request)
{
    // Find the domain by its ID
   

    // Validate the input
    $validated = $request->validate([
        'id'=>'required|integer',
        'domainname' => 'required|string|max:255',
        'companyname' => 'required|string|max:255',
        'mail_header' => 'nullable|string',
        'mail_footer' => 'nullable|string',
        'server_address' => 'nullable|string|max:255',
        'port' => 'nullable|integer',
        'authentication' => 'nullable|string|max:255',
        'username' => 'nullable|string|max:255',
        'password' => 'nullable|string|max:255',
        'tomail_id' => 'nullable|string|email|max:255',
    ]);
    $domain = Domains::findOrFail($request->id); 
    $domain->update($validated);

    return redirect()->route('domain');
}

public function delete($id)
{
    Domains::destroy($id);
    return redirect()->route('domain');

}
}