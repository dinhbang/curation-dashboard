<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_rules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->integer('rule_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['category_id','rule_id']);
            $table->foreign('rule_id')->references('id')->on('rules') ->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories') ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_rules');
    }
}
