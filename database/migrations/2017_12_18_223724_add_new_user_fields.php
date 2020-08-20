<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewUserFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //$table->renameColumn('name', 'first_name');
            $table->string('title', 100)->nullable();
            $table->string('surname', 250)->nullable();
            $table->string('address_one', 250)->nullable();
            $table->string('address_two', 250)->nullable();
            $table->string('city', 250)->nullable();
            $table->string('postcode', 4)->nullable();
            $table->string('phone', 100)->nullable();
            $table->string('fax', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['title', 'surname', 'address_one', 'address_two', 'city', 'postcode', 'phone', 'fax']);
        });
    }
}
