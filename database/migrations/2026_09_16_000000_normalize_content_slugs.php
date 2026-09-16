<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration {
    public function up(): void
    {
        foreach (['destinations' => 'name', 'blogs' => 'title'] as $table => $column) {
            $records = DB::table($table)->select('id', $column)->get();

            foreach ($records as $record) {
                DB::table($table)
                    ->where('id', $record->id)
                    ->update(['slug' => "__slug_migration_{$record->id}"]);
            }

            foreach ($records as $record) {
                DB::table($table)
                    ->where('id', $record->id)
                    ->update(['slug' => Str::slug($record->{$column})]);
            }
        }
    }

    public function down(): void
    {
    }
};