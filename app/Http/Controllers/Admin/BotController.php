<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BotSetting;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BotController extends Controller
{
    public function index()
    {
        $settings = [
            'bot_status' => BotSetting::get('bot_status', 'enabled'),
            'bot_interval' => BotSetting::get('bot_interval', 'hourly'),
            'allowed_types' => json_decode(BotSetting::get('allowed_types', '["text", "ask", "poll"]'), true) ?? [],
        ];

        $bots = User::where('email', 'like', '%@arraytype.local')->with('profile')->latest()->get();

        return view('admin.bots.index', compact('settings', 'bots'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'bot_status' => 'required|in:enabled,disabled',
            'bot_interval' => 'required|in:30min,hourly,4hours,twice_daily,daily',
            'allowed_types' => 'array',
            'allowed_types.*' => 'in:text,ask,poll,tool,news'
        ]);

        BotSetting::set('bot_status', $request->input('bot_status'));
        BotSetting::set('bot_interval', $request->input('bot_interval'));
        BotSetting::set('allowed_types', json_encode($request->input('allowed_types', [])));

        return back()->with('success', 'Bot settings updated successfully.');
    }

    public function createBot(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'profession' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'bot_task' => 'required|in:post_content,post_news,create_groups,send_connections'
        ]);

        $baseEmail = strtolower(Str::slug($request->input('name'))) . '@arraytype.local';
        $email = $baseEmail;
        $counter = 1;

        while (User::where('email', $email)->exists()) {
            $email = strtolower(Str::slug($request->input('name'))) . $counter . '@arraytype.local';
            $counter++;
        }

        $user = User::create([
            'name' => $request->input('name') . ' (' . $request->input('profession') . ')',
            'email' => $email,
            'password' => Hash::make('password123'),
            'bot_task' => $request->input('bot_task'),
        ]);

        Profile::create([
            'user_id' => $user->id,
            'bio' => $request->input('bio') ?? "I build and research artificial intelligence systems.",
            'skills' => json_encode(['AI', 'Machine Learning']),
        ]);

        return back()->with('success', 'Bot persona created successfully.');
    }

    public function updateBot(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'bot_task' => 'required|in:post_content,post_news,create_groups,send_connections'
        ]);

        // Ensure we are only updating a bot account
        if (!Str::endsWith($user->email, '@arraytype.local')) {
            return back()->with('error', 'You can only edit automated bot personas.');
        }

        $user->update([
            'name' => $request->input('name'),
            'bot_task' => $request->input('bot_task'),
        ]);

        return back()->with('success', 'Bot persona updated successfully.');
    }

    public function scrapeAndPost(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
            'type' => 'required|in:product,tool,news'
        ]);

        $bots = User::where('email', 'like', '%@arraytype.local')->get();
        if ($bots->isEmpty()) {
            return back()->with('error', 'No bots are available to post. Please create one.');
        }

        $bot = $bots->random();
        $url = $request->input('url');

        try {
            // Simple fetch - in a real app you'd use a better HTTP client and handle timeouts
            $html = file_get_contents($url);

            if (!$html) {
                return back()->with('error', 'Could not fetch the URL content.');
            }

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
                $title = "Interesting " . ucfirst($request->input('type')) . " Link";
            }
            if (empty($description)) {
                $description = "Check out this link shared by our community: " . $url;
            }

            // Route to proper table based on type
            if ($request->input('type') === 'product') {
                \App\Models\Product::create([
                    'user_id' => $bot->id,
                    'category_id' => 1, // Default fallback category (e.g. AI Tools)
                    'name' => mb_substr($title, 0, 255),
                    'tagline' => mb_substr($description, 0, 255),
                    'description' => mb_substr($description, 0, 1000) . "\n\nLink: " . $url,
                    'website_url' => $url,
                    'status' => 'approved',
                ]);
            } elseif ($request->input('type') === 'tool') {
                \App\Models\Tool::create([
                    'user_id' => $bot->id,
                    'name' => mb_substr($title, 0, 255),
                    'description' => mb_substr($description, 0, 1000) . "\n\nLink: " . $url,
                    'url' => $url,
                ]);
            } elseif ($request->input('type') === 'news') {
                \App\Models\News::create([
                    'user_id' => $bot->id,
                    'title' => mb_substr($title, 0, 255),
                    'summary' => mb_substr($description, 0, 1000),
                    'content' => "Check out the full story here: " . $url,
                    'source_url' => $url,
                    'status' => 'approved',
                ]);
            }

            return back()->with('success', "Bot '{$bot->name}' successfully posted the {$request->input('type')}!");
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to scrape the URL: ' . $e->getMessage());
        }
    }
    public function triggerBot()
    {
        try {
            \Illuminate\Support\Facades\Artisan::call('bots:generate-activity');
            $output = \Illuminate\Support\Facades\Artisan::output();
            return back()->with('success', 'Bot activity triggered successfully! Result: ' . $output);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to trigger bot: ' . $e->getMessage());
        }
    }
}
