<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Upload extends Controller
{
    public function UploadFile(Request $req)
    {
    	echo $req->file('img')->store('Uploads');
    }
}
