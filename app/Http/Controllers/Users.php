<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Users extends Controller
{
    public function getUserList()
	{
		error_log('i am user list');
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

	public function updateUserStatus(Request $req, $userId, $newStatus)
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

	public function userAuthenticate(Request $req)
	{
		$random = str_random(30);
		error_log($random);

		$data = $req->input();

		$statusArr = DB::table('users')
				->where('mobile_no',$data['mobileNo'])
				->where('password',$data['password'])
				->pluck('status');

		if(count($statusArr) == 1 && $statusArr[0]=='ACTIVE'){

			DB::table('users')
			->where('status','ACTIVE')
			->where('mobile_no',$data['mobileNo'])
			->where('password',$data['password'])
			->update([
				'token' => $random
			]);

			$sql = DB::table('users')
				->where('mobile_no',$data['mobileNo'])
				->where('password',$data['password'])
				->get();

		return $sql;
		}

		return "User Not Active";
	}
}

