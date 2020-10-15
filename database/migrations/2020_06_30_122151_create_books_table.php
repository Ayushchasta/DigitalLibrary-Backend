<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('uploaderId');
            $table->string('bookName', 100);
            $table->string('author', 100);
            $table->string('publisher', 100);
            $table->string('fileName' ,300);
            $table->boolean('adminApproval')->default('0');
            $table->boolean('publisherApproval')->default('0');
            $table->integer('countDownload')->default('0');
            $table->integer('countView')->default('0');
            $table->timestamp('time')->default(DB::raw('CURRENT_TIMESTAMP'));

            
            $table->foreign('uploaderId')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
