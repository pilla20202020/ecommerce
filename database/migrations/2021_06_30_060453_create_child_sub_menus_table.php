<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChildSubMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('child_sub_menus', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('slug', 191);
            $table->bigInteger('sub_menu_id')->unsigned()->index();
            $table->string('name')->nullable();
            $table->text('url')->nullable();
            $table->integer('order')->nullable();
            $table->string('icon')->nullable();
            $table->unique(['sub_menu_id', 'slug']);
            $table->foreign('sub_menu_id')
                ->references('id')
                ->on('sub_menus')
                ->onDelete('cascade');
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
        Schema::dropIfExists('child_sub_menus');
    }
}
