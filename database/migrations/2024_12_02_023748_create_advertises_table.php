<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('advertises', function (Blueprint $table) {
            $table->id();
            $table->text('top_bar_ad');
            $table->text('top_bar_ad_url');
            $table->boolean('top_bar_ad_status');
            $table->text('middle_ad');
            $table->text('middle_ad_url');
            $table->boolean('middle_ad_status');
            $table->text('bottom_bar_ad');
            $table->text('bottom_bar_ad_url');
            $table->boolean('bottom_bar_ad_status');
            $table->text('sidebar_ad');
            $table->text('sidebar_ad_url');
            $table->boolean('sidebar_ad_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertises');
    }
};