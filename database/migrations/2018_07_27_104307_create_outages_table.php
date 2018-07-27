<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateOutagesTable.
 */
class CreateOutagesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('outages', function(Blueprint $table) {
            $table->increments('id');
			$table->string('hash');
			$table->dateTime('outage_from');
			$table->dateTime('outage_to');
			$table->string('locality');
			$table->text('roads');

            $table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('outages');
	}
}
