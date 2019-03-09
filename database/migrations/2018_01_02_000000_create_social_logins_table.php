<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Models\SocialLogin;

class CreateSocialLoginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_logins', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('oauth_provider_id')->unsigned();
            $table->foreign('oauth_provider_id')->references('id')->on('oauth_providers')->onDelete('cascade');

            $table->string('provider_user_id')->nullable();
            $table->string('provider_user_data')->nullable();
            $table->string('provider_is_public')->nullable();

            $table->string('access_token')->nullable();
            $table->string('refresh_token')->nullable();

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
        Schema::dropIfExists('social_logins');
    }
}
