<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Group;

try {
    DB::statement('ALTER TABLE groups ADD COLUMN slug VARCHAR(255) NULL UNIQUE AFTER name');
    echo "Slug column added.\n";
} catch (\Exception $e) {
    echo "Column might exist: " . $e->getMessage() . "\n";
}

$groups = Group::all();
foreach ($groups as $g) {
    $g->slug = Str::slug($g->name);
    $g->save();
}
echo "Slugs populated.\n";
