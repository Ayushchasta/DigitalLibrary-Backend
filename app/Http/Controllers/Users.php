<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Users extends Controller
{
    public function userList()
	{
		return DB::table('users')->get();
	}

	public function insertUser(Request $req)
	{
	
		error_log('CreateUser');

		$data = $req->json()->all();

		$check = $data['role'];

		if( $check == 'READER' || $check == 'PUBLISHER')
		{
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

	}

	public function deleteUser(Request $req, $userId)
	{
	
		error_log('DeleteUser');
		error_log($userId);
		$data = $req->json()->all();

		$user= DB::table('users')
		->where('id', $userId)
		->where('role', '!=' , 'ADMIN')
		->delete();
		
	   // $data['id']
	}

	public function userStatus(Request $req, $userId, $newStatus)
	{
		error_log($userId);
		error_log($newStatus);

		if($newStatus == "ACTIVE" || $newStatus == "INACTIVE")
		{
			return DB::table('users')
			->where('id',$userId)
			->update([
				'status'=> $newStatus
			]);
		}
	}	

}

