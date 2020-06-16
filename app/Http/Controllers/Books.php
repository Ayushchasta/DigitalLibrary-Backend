<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Books extends Controller
{
    public function GetBooks()
	{
		return DB::table('books')->get();
	}
	public function InsertBook(Request $req)
	{
	
		error_log('CreateUser');

		$data = $req->json()->all();

		$user= DB::table('books')
		
		->insert(
		[
			'bookname' => $data['bookName'],
			'author' => $data['bookAuthor'],
			'publisher' => $data['bookPublisher'],

		]
		);
	}

	public function DeleteBook(Request $req, $bookId)
	{
	
		error_log('DeleteBook');
		error_log($bookId);
		$data = $req->json()->all();

		$user= DB::table('books')
		->where('id',$bookId)
		->delete();
		
	   // $data['id']
	}
}
