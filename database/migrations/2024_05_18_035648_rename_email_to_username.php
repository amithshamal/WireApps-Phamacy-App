<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameEmailToUsername extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Rename the email column to username
            $table->renameColumn('email', 'username');
        });
    }
    
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Rename username back to email
            $table->renameColumn('username', 'email');
        });
    }
}
