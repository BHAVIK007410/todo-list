<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('todo_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('list_id');
            $table->bigInteger('todo_id');
            $table->foreign('todo_id')->references('todo_id')->on('todos')->onDelete('cascade')->onUpdate('cascade');
            $table->string('list_item')->length(200);
            $table->tinyInteger('is_completed')->default('0')->comment('0=not completed, 1=completed');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todo_items');
    }
};
