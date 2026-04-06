<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('citizen','agent','admin','superadmin') NOT NULL DEFAULT 'citizen'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('citizen','agent','admin') NOT NULL DEFAULT 'citizen'");
    }
};
