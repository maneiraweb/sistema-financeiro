<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryRevenuesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('category_revenues', function(Blueprint $table) {
            $table->increments('id');
			$table->string('nome');
			
			\Kalnoy\Nestedset\NestedSet::columns($table);

			$table->integer('cliente_id')->unsigned();
            $table->foreign('cliente_id')->references('id')->on('clientes');

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
		Schema::drop('category_revenues');
	}

}
