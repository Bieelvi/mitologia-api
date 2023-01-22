<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_oficial', function(Blueprint $table) {
            $table->renameColumn('firstname', 'nickname');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_oficial', function(Blueprint $table) {
            $table->renameColumn('nickname', 'firstname');
        });
    }
};
