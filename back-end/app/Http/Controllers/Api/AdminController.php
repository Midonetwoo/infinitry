<?php

namespace App\Http\Controllers\Api;

//import model admin
use App\Models\Admin;

use App\Http\Controllers\Controller;

//import resource AdminResource
use App\Http\Resources\AdminResource;
use Illuminate\Http\Request;



class AdminController extends Controller
{
    /**
     * index
     * 
     * @return void
     */
    public function index()
    {
        //get all admin
        $admin = Admin::latest()->paginate(5);

        //return collection of admin as a resource
        return new AdminResource(true, 'List Data Admin', $admin);
    }

    
    //masih belum bisa
    public function __invoke(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required'],
            'password' => ['required', 'min:8']
        ]);

        if(Admin::check($credentials)) {
            return response()->json($credentials);
        }

        return response()->json([
            'error' => 'Your credentials doesnt match' 
        ]);
    }
}
