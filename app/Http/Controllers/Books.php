<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\File;
use Illuminate\Support\Facades\File as LaraFile;
use Illuminate\Support\Facades\Storage;


class Books extends Controller {

    public function getAllPublishedBooks() {

		$rs = DB::table('books')
				->select('books.id as id',
						'users.name as uploaderName',
						'books.bookName as bookName',
						'users.id as uploaderId',
						'books.author as author',
						'books.publisher as publisher',
						'books.fileName as fileName',
						'books.adminApproval as adminApproval',
						'books.publisherApproval as publisherApproval',
						'books.countDownload as countDownload',
						'books.countView as countView',)
				->join('users','books.uploaderId','=','users.id')
				->get();

		return $rs;
	}

	public function getMyPublishedBooks(Request $req) {

		error_log('message');
		$userId = $req->header('user_id');
		error_log($userId);
		
		$rs = DB::table('books')
				->select('books.id as id',
						'books.uploaderId as uploaderId',
						'books.bookName as bookName',
						'books.author as author',
						'books.publisher as publisher',
						'books.fileName as fileName',
						'books.adminApproval as adminApproval',
						'books.publisherApproval as publisherApproval',
						'books.countDownload as countDownload',
						'books.countView as countView')
				->where('books.uploaderId', $userId)
				->get();

		return $rs;
	}

	public function getAllActiveBooks(Request $req) {

		error_log('message');
		
		$rs = DB::table('books')
				->select('books.id as id',
						'books.uploaderId as uploaderId',
						'books.bookName as bookName',
						'books.author as author',
						'books.publisher as publisher',
						'books.fileName as fileName',
						'books.adminApproval as adminApproval',
						'books.publisherApproval as publisherApproval',
						'books.countDownload as countDownload',
						'books.countView as countView')
				->where('books.adminApproval', 1)
				->where('books.publisherApproval', 1)
				->get();

		return $rs;
	}

	public function insertBook(Request $req) {
	
		error_log('InsertBook');
		$fileName = $req->file('file')->store('Uploads');
		echo $fileName;

		$userId = $req->header('user_id');

		$bookName = $req->input('bookName');
		$bookPublisher = $req->input('bookPublisher');
		$bookAuthor = $req->input('bookAuthor');

		$user= DB::table('books')
		
		->insert(
		[
			'uploaderId' => $userId,
			'fileName' => $fileName,
			'bookName' => $bookName,
			'author' => $bookAuthor,
			'publisher' => $bookPublisher,

		]
		);
	}

	public function deleteBook(Request $req, $bookId) {
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

	public function downloadBook(Request $req, $fileName) {
		error_log('DownloadBook');
		$bookName = $req->input('bookName');
		error_log($fileName);
		error_log($bookName);

		$increment = DB::table('books')
		->where('fileName', 'Uploads/'.$fileName)
		->increment('countDownload', 1);

		return Storage::download('Uploads/' . $fileName , $bookName . '.pdf');
	}

	public function searchBook(Request $req) {
		error_log('SearchBook1');
		error_log($req);
		$data = $req->input('searchString');
		error_log('SearchBook2');

		error_log($data);
		error_log('SearchBook3');

		error_log('before query');
		$wantedBook = DB::table('books')
		->where('bookName', 'LIKE' , '%'.$data.'%')
		->where('books.adminApproval', 1)
		->where('books.publisherApproval', 1)
		->get();
		error_log('after query');
		error_log('after wanted called');

		return $wantedBook;
	}

	public function viewBook(Request $req, $fileName) {
		error_log('ViewBook');

		$increment = DB::table('books')
		->where('fileName', 'Uploads/'.$fileName)
		->increment('countView', 1);

		return Storage::Response('Uploads/' . $fileName);
	}

	public function updateBookAdminStatus(Request $req, $bookId, $adminStatus) {
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

	public function updateBookPublisherStatus(Request $req, $bookId, $publisherStatus) {
		error_log($bookId);
		error_log($publisherStatus);

		$userId = $req->header('user_id');

		if($publisherStatus == 1 || $publisherStatus == 0)
		{
			return DB::table('books')
			->where('id',$bookId)
			->where('uploaderId', $userId)
			->update([
				'publisherApproval'=> $publisherStatus
			]);
		}
	}

}