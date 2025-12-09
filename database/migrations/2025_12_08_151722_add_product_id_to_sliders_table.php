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
    Schema::table('sliders', function (Blueprint $table) {
        // প্রোডাক্ট আইডি যোগ করছি, ইমেজ এখন নাল হতে পারে
        $table->foreignId('product_id')->nullable()->after('id')->constrained()->onDelete('cascade');
        $table->string('image')->nullable()->change(); // ইমেজ এখন অপশনাল
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            //
        });
    }
};
