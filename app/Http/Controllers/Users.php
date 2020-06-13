<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Users extends Controller
{
    public function UserList()
	{
		return DB::table('users')->get();
	}
	public function ReaderList()
	{
		return DB::table('users')
		->where('role','reader')
		->get();

	}
	public function LibList()
	{
		error_log('LibrarianList');
		return DB::table('users')
		->where('role','librarian')
		->get();
	}
	public function InsertUser(Request $req)
	{
	
		error_log('CreateUser');

		$data = $req->json()->all();

		$user= DB::table('users')
		
		->insert(
		[
			'name' => $data['name'],
			'role' => $data['role'],
			'mobile_no' => $data['mobile_no'],
			'password' => $data['password'],

		]
		);
	}

	public function DeleteUser(Request $req, $userId)
	{
	
		error_log('DeleteUser');
		error_log($userId);
		$data = $req->json()->all();

		$user= DB::table('users')
		->where('id',$userId)
		->delete();
		
	   // $data['id']
	}

}

