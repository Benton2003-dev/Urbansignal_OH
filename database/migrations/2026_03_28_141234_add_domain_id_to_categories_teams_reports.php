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
        Schema::table('categories', function (Blueprint $table) {
            $table->foreignId('domain_id')->nullable()->constrained('domains')->nullOnDelete()->after('id');
        });

        Schema::table('teams', function (Blueprint $table) {
            $table->foreignId('domain_id')->nullable()->constrained('domains')->nullOnDelete()->after('id');
        });

        Schema::table('reports', function (Blueprint $table) {
            $table->foreignId('domain_id')->nullable()->constrained('domains')->nullOnDelete()->after('category_id');
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['domain_id']);
            $table->dropColumn('domain_id');
        });

        Schema::table('teams', function (Blueprint $table) {
            $table->dropForeign(['domain_id']);
            $table->dropColumn('domain_id');
        });

        Schema::table('reports', function (Blueprint $table) {
            $table->dropForeign(['domain_id']);
            $table->dropColumn('domain_id');
        });
    }
};
