<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
  {
      Schema::table('events', function (Blueprint $table) {
          // Menghubungkan event dengan user yang memiliki role 'organizer'
          $table->foreignId('organizer_id')->nullable()->constrained('users')->onDelete('cascade');
      });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
      Schema::table('events', function (Blueprint $table) {
          $table->dropForeign(['organizer_id']);
          $table->dropColumn('organizer_id');
      });
  }
};
