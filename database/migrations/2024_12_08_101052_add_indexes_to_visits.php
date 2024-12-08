<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->index(['ip_address', 'user_agent', 'user_id', 'created_at']);
        });
    }

    public function down()
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->dropIndex(['ip_address', 'user_agent', 'user_id', 'created_at']);
        });
    }
};