<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrchidRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('term_relationships', function (Blueprint $table) {
            $table->unsignedInteger('post_id');
            $table->unsignedInteger('term_taxonomy_id');
            $table->integer('term_order')->default(0);
            $table->index(['post_id', 'term_taxonomy_id']);
            $table->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('term_taxonomy_id')
                ->references('id')
                ->on('term_taxonomy')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('term_relationships');
    }
}
