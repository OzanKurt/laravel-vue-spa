<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOauthProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauth_providers', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('display_name');
            $table->boolean('is_enabled')->default(true);

            $table->string('client_id')->nullable();
            $table->string('client_secret')->nullable();

            $table->string('link')->nullable();
            $table->string('icon')->nullable();
            $table->string('image')->nullable();

            $table->string('color');
            $table->text('scopes');

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
        Schema::dropIfExists('oauth_providers');
    }
}
