<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\BotSetting;

try {
    if (!Schema::hasTable('bot_settings')) {
        Schema::create('bot_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });
        echo "Table created.\n";
    } else {
        echo "Table already exists.\n";
    }

    // Insert Default Settings
    if (!BotSetting::where('key', 'bot_status')->exists()) {
        BotSetting::create(['key' => 'bot_status', 'value' => 'enabled']);
        BotSetting::create(['key' => 'bot_interval', 'value' => 'hourly']);
        BotSetting::create(['key' => 'allowed_types', 'value' => json_encode(['text', 'ask', 'poll'])]);
        echo "Default settings inserted.\n";
    }

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
