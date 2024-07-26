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
        Schema::create('dynamic_units', function (Blueprint $table) {
            $table->id();
            $table->string("name")->comment("属性名称");
            $table->string("code")->index()->nullable()->comment("属性标识");
            $table->timestamps();
            $table->comment("动态单元信息表");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dynamic_units');
    }
};
