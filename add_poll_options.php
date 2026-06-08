<?php

use Illuminate\Support\Facades\DB;

try {
    DB::statement('ALTER TABLE posts ADD COLUMN poll_options JSON NULL');
    echo "poll_options column added.\n";
} catch (\Exception $e) {
    echo "Column might exist: " . $e->getMessage() . "\n";
}
