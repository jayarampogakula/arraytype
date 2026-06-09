<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Product;

class TelegramWebhookController extends Controller
{
    /**
     * Handle incoming webhooks from Telegram.
     */
    public function handle(Request $request)
    {
        // Log the incoming request for debugging
        Log::info('Incoming Telegram Webhook', $request->all());

        $message = $request->input('message');

        if (!$message || !isset($message['text'])) {
            return response()->json(['status' => 'ignored', 'reason' => 'No text message']);
        }

        $text = $message['text'];
        $chatId = $message['chat']['id'];

        // Optionally restrict by Chat ID or User ID (Hardcoded for beta or add to .env)
        // if ($chatId != env('TELEGRAM_ALLOWED_CHAT_ID')) {
        //     return response()->json(['status' => 'ignored', 'reason' => 'Unauthorized chat']);
        // }

        // Extract URL using regex
        preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $text, $matches);
        $urls = $matches[0] ?? [];

        if (empty($urls)) {
            return response()->json(['status' => 'ignored', 'reason' => 'No URL found in message']);
        }

        $url = $urls[0]; // Take the first URL found

        try {
            $product = $this->scrapeAndCreateProduct($url);
            
            if ($product) {
                $this->sendMessage($chatId, "🚀 Product successfully launched on ArrayType!\n\n**Title:** {$product->name}\n**Link:** " . route('products.show', $product));
                return response()->json(['status' => 'success', 'product_id' => $product->id]);
            } else {
                $this->sendMessage($chatId, "❌ Failed to scrape or launch product from URL: {$url}");
                return response()->json(['status' => 'error', 'reason' => 'Scraping failed']);
            }
        } catch (\Exception $e) {
            Log::error('Telegram Webhook Error: ' . $e->getMessage());
            $this->sendMessage($chatId, "⚠️ Error processing link: " . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Scrape the URL and create a Product.
     */
    private function scrapeAndCreateProduct($url)
    {
        // 1. Get a random active Bot Persona
        $bot = User::where('email', 'like', '%@arraytype.local')->inRandomOrder()->first();
        if (!$bot) {
            throw new \Exception('No Bot Persona available to post.');
        }

        // 2. Fetch HTML content
        $response = \Illuminate\Support\Facades\Http::timeout(30)->withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
        ])->get($url);

        if (!$response->successful()) {
            throw new \Exception('Could not fetch the URL content. Status: ' . $response->status());
        }

        $html = $response->body();

        $doc = new \DOMDocument();
        @$doc->loadHTML($html);

        $title = '';
        $description = '';
        $image = '';

        // Extract Meta Tags
        $tags = $doc->getElementsByTagName('meta');
        foreach ($tags as $tag) {
            if ($tag instanceof \DOMElement) {
                if ($tag->getAttribute('property') === 'og:title') {
                    $title = $tag->getAttribute('content');
                }
                if ($tag->getAttribute('property') === 'og:description') {
                    $description = $tag->getAttribute('content');
                }
                if ($tag->getAttribute('property') === 'og:image') {
                    $image = $tag->getAttribute('content');
                }
            }
        }

        // Fallbacks
        if (empty($title)) {
            $titles = $doc->getElementsByTagName('title');
            if ($titles->length > 0) {
                $title = $titles->item(0)->nodeValue;
            }
        }
        if (empty($description)) {
            foreach ($tags as $tag) {
                if ($tag instanceof \DOMElement && $tag->getAttribute('name') === 'description') {
                    $description = $tag->getAttribute('content');
                }
            }
        }

        if (empty($title)) {
            $title = "Interesting Discovery";
        }
        if (empty($description)) {
            $description = "Check out this link shared via Telegram.";
        }

        // 3. Create the Product
        $product = Product::create([
            'user_id' => $bot->id,
            'category_id' => 1, // Default fallback category (e.g. AI Tools)
            'name' => mb_substr($title, 0, 255),
            'tagline' => mb_substr($description, 0, 255),
            'description' => mb_substr($description, 0, 1000) . "\n\nLink: " . $url,
            'website_url' => $url,
            'status' => 'approved',
        ]);

        return $product;
    }

    /**
     * Send a message back to the Telegram chat.
     */
    private function sendMessage($chatId, $text)
    {
        $botToken = env('TELEGRAM_BOT_TOKEN');
        
        if (!$botToken) {
            Log::warning('Telegram BOT_TOKEN is not configured in .env. Cannot send reply.');
            return;
        }

        $url = "https://api.telegram.org/bot{$botToken}/sendMessage";
        $data = [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'Markdown'
        ];

        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
                'ignore_errors' => true,
            ]
        ];

        $context  = stream_context_create($options);
        $result = @file_get_contents($url, false, $context);
        
        if ($result === false) {
            Log::error('Failed to send Telegram message to ' . $chatId);
        }
    }
}
