<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDTSTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dts_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('msisdn')->index()->nullable();
            $table->string('service');
            $table->string('transaction_id')->index();
            $table->bigInteger('requested_at');
            $table->bigInteger('response_at')->nullable();
            $table->bigInteger('result_at')->nullable();
            $table->integer('response_milliseconds')->nullable();
            $table->integer('result_milliseconds')->nullable();
            $table->json('request');
            $table->longText('request_body');
            $table->longText('response_body')->nullable();
            $table->longText('result_body')->nullable();
            $table->string('response_message')->nullable();
            $table->string('result_message')->nullable();
            $table->string('status')->nullable();
            $table->boolean('success')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dts_transactions');
    }
}