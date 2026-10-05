<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function getConnection(): ?string
    {
        return config('aircrafts.connection');
    }

    public function up(): void
    {
        Schema::create(config('aircrafts.table', 'aircrafts'), function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->char('code', 3)->unique();
            $table->string('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config('aircrafts.table', 'aircrafts'));
    }
};
