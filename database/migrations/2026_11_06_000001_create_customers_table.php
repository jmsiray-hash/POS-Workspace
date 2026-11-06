<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('customers')) {
            Schema::create('customers', function (Blueprint $table): void {
                $table->id();
                $table->string('full_name', 100);
                $table->string('email', 100);
                $table->string('phone', 20)->nullable();
                $table->timestamps();
            });

            return;
        }

        if (! Schema::hasColumn('customers', 'updated_at')) {
            Schema::table('customers', function (Blueprint $table): void {
                $table->timestamp('updated_at')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
