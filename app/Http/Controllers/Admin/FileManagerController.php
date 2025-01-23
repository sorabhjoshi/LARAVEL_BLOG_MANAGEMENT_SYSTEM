<?php

  

namespace App\Http\Controllers\Admin;

  

use Illuminate\Http\Request;

  

class FileManagerController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index(Request $request)

    {   

        return response()->view('Blogbackend.filemanager');

    }

}