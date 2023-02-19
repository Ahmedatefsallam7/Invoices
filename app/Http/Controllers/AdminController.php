<?php

namespace App\Http\Controllers;

use App\Models\User;
use Aws\MediaConnect\MediaConnectClient;
use Illuminate\Http\Request;
use Symfony\Component\Mailer\Transport\Smtp\Auth\LoginAuthenticator;

class AdminController extends Controller
{
    
    
    public function index($id)
    {
        if(view()->exists($id)){
            return view($id);
        }
        else
        {
            return view('404');
        }

     //   return view($id);
    }

  
 


    
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        //
    }

   
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        //
    }

   
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }
}