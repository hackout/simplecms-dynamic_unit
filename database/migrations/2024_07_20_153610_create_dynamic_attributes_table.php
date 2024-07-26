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
        Schema::create('dynamic_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId("dynamic_unit_id")->constrained("dynamic_units")->index()->comment('属性ID');
            $table->string("name")->comment("名称");
            $table->string("code")->nullable()->comment("附加属性标识");
            $table->timestamps();
            $table->comment('动态单元属性表');
        });
        Schema::create('customs_attributes', function (Blueprint $table) {
            $table->integer('dynamic_attribute_id')->comment("属性ID");
            $table->string("model_id")->comment("关联ID");
            $table->string("model_type")->nullable()->comment("关联类");
            $table->json("extra")->nullable()->comment("扩展属性");
            $table->primary(['dynamic_attribute_id', 'model_id'], 'customs_attribute');
            $table->comment("动态单元关联表");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dynamic_attributes');
        Schema::dropIfExists('customs_attributes');
    }
};
