<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Nếu CHƯA có bảng users, tạo mới:
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->string('password');
                $table->enum('role', ['admin','customer'])->default('customer')->index();
                $table->timestamps();
            });
            return;
        }

        // Nếu ĐÃ có bảng users, chỉ thêm các cột còn thiếu:
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users','name'))      $table->string('name')->after('id');
            if (!Schema::hasColumn('users','email'))     $table->string('email')->unique()->after('name');
            if (!Schema::hasColumn('users','password'))  $table->string('password')->after('email');
            if (!Schema::hasColumn('users','role'))      $table->enum('role',['admin','customer'])->default('customer')->index()->after('password');
        });
    }

    public function down(): void {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (Schema::hasColumn('users','role'))     $table->dropColumn('role');
                // Không drop name/email/password để tránh mất dữ liệu ngoài ý muốn
            });
        }
    }
};
