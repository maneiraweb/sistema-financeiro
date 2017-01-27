<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContaBancariasTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('conta_bancarias', function(Blueprint $table) {
            $table->increments('id');
			$table->string('nome');
			$table->string('agencia')->nullable();
			$table->string('conta')->nullable();
			$table->boolean('default')->default(0);

			$table->integer('banco_id')->unsigned();
			$table->foreign('banco_id')->references('id')->on('bancos');

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
		Schema::drop('conta_bancarias');
	}

}
