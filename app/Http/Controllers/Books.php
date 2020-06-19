<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\File;
use Illuminate\Support\Facades\File as LaraFile;
use Illuminate\Support\Facades\Storage;



class Books extends Controller
{
    public function GetBooks()
	{
		return DB::table('books')->get();
	}
	public function InsertBook(Request $req)
	{
	
		error_log('InsertBook');
		$fileName = $req->file('file')->store('Uploads');
		echo $fileName;

		$bookName = $req->input('bookName');
		$bookPublisher = $req->input('bookPublisher');
		$bookAuthor = $req->input('bookAuthor');

		$user= DB::table('books')
		
		->insert(
		[
			'fileName' => $fileName,
			'bookName' => $bookName,
			'author' => $bookAuthor,
			'publisher' => $bookPublisher,

		]
		);
	}

	public function DeleteBook(Request $req, $bookId)
	{
		error_log('DeleteBook');
		error_log($bookId);

		$fileName = DB::table('books')->where('id', $bookId)->pluck('fileName');

		error_log($fileName[0]);

		error_log("Removing"); 
		//unlink(storage_path('app/'.$filename[0]));
		Storage::delete($fileName[0]);
		error_log("Deleted"); 

		$user= DB::table('books')
		->where('id', $bookId)
		->delete();
	}

	public function DownloadBook(Request $req, $fileName)
	{
		error_log('DownloadBook');
		$bookName = $req->input('bookName');
		error_log($fileName);
		error_log($bookName);

		return Storage::download('Uploads/' . $fileName , $bookName . '.pdf');
	}

	public function ViewBook(Request $req, $fileName)
	{
		error_log('DownloadBook');
		return Storage::Response('Uploads/' . $fileName);
	}

	public function BookStatus(Request $req, $bookId, $adminStatus)
	{
		error_log($bookId);
		error_log($adminStatus);

		if($adminStatus == 1 || $adminStatus == 0)
		{
			return DB::table('books')
			->where('id',$bookId)
			->update([
				'adminApproval'=> $adminStatus
			]);
		}
	}	

}