<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FeedController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;

Route::get('/', [FeedController::class, 'index'])->name('home');
Route::get('/dashboard', [FeedController::class, 'index'])->name('dashboard');
Route::get('/@{user}', [UserController::class, 'show'])->name('users.show');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])
    ->whereNumber('product')
    ->name('products.show');
Route::get('/leaderboards/products/{range}', [ProductController::class, 'leaderboard'])
    ->whereIn('range', ['today', 'week', 'month', 'year'])
    ->name('products.leaderboard');

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{news}', [NewsController::class, 'show'])
    ->whereNumber('news')
    ->name('news.show');

Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{job}', [JobController::class, 'show'])
    ->whereNumber('job')
    ->name('jobs.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/explore', 'explore')->name('explore');
    Route::post('/feed', [FeedController::class, 'store'])->name('feed.store');
    Route::post('/posts/{post}/like', [FeedController::class, 'like'])->name('posts.like');
    Route::post('/posts/{post}/comment', [FeedController::class, 'comment'])->name('posts.comment');
    Route::post('/posts/{post}/poll-vote', [FeedController::class, 'votePoll'])->name('posts.poll-vote');

    Route::post('/users/{user}/follow', [App\Http\Controllers\FollowController::class, 'store'])->name('users.follow');
    Route::delete('/users/{user}/unfollow', [App\Http\Controllers\FollowController::class, 'destroy'])->name('users.unfollow');

    Route::get('/network', [\App\Http\Controllers\NetworkController::class, 'index'])->name('network.index');
    Route::post('/network/{user}/connect', [\App\Http\Controllers\NetworkController::class, 'connect'])->name('network.connect');
    Route::post('/network/{connection}/accept', [\App\Http\Controllers\NetworkController::class, 'accept'])->name('network.accept');
    Route::delete('/network/{connection}/ignore', [\App\Http\Controllers\NetworkController::class, 'ignore'])->name('network.ignore');

    Route::get('/messages', [\App\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{conversation}', [\App\Http\Controllers\MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{conversation}', [\App\Http\Controllers\MessageController::class, 'store'])->name('messages.store');
    Route::post('/messages/start/{user}', [\App\Http\Controllers\MessageController::class, 'start'])->name('messages.start');

    Route::post('/groups/{group}/join', [GroupController::class, 'join'])->name('groups.join');
    Route::delete('/groups/{group}/leave', [GroupController::class, 'leave'])->name('groups.leave');
    Route::resource('groups', GroupController::class);
    Route::resource('tools', ToolController::class);
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('products.store');
    Route::post('/products/{product}/vote', [ProductController::class, 'vote'])
        ->middleware('throttle:30,1')
        ->name('products.vote');
    Route::post('/products/{product}/comment', [ProductController::class, 'comment'])
        ->middleware('throttle:10,1')
        ->name('products.comment');

    Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create');
    Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
    Route::post('/jobs/{job}/apply', [JobController::class, 'apply'])->name('jobs.apply');

    Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('/news', [NewsController::class, 'store'])->name('news.store');
    Route::post('/news/{news}/comment', [NewsController::class, 'comment'])
        ->middleware('throttle:10,1')
        ->name('news.comment');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Premium & Promotion Routes
    Route::get('/premium', [\App\Http\Controllers\PremiumController::class, 'index'])->name('premium.index');
    Route::post('/premium/upgrade', [\App\Http\Controllers\PremiumController::class, 'upgrade'])->name('premium.upgrade');
    Route::post('/premium/promote', [\App\Http\Controllers\PremiumController::class, 'promote'])->name('premium.promote');
    Route::post('/premium/promote-job', [\App\Http\Controllers\PremiumController::class, 'promoteJob'])->name('premium.promote-job');
    Route::post('/products/{product}/cta', [\App\Http\Controllers\PremiumController::class, 'updateCta'])->name('products.update-cta');
    Route::get('/products/{product}/click', [\App\Http\Controllers\ProductController::class, 'recordClick'])->name('products.click');

    // Admin Routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/bots', [\App\Http\Controllers\Admin\BotController::class, 'index'])->name('bots.index');
        Route::post('/bots/settings', [\App\Http\Controllers\Admin\BotController::class, 'updateSettings'])->name('bots.settings');
        Route::post('/bots/create', [\App\Http\Controllers\Admin\BotController::class, 'createBot'])->name('bots.create');
        Route::post('/bots/scrape-link', [\App\Http\Controllers\Admin\BotController::class, 'scrapeAndPost'])->name('bots.scrape');
        Route::post('/bots/trigger', [\App\Http\Controllers\Admin\BotController::class, 'triggerBot'])->name('bots.trigger');
        Route::put('/bots/{user}', [\App\Http\Controllers\Admin\BotController::class, 'updateBot'])->name('bots.update');

        Route::get('/products/pending', [\App\Http\Controllers\Admin\ProductModerationController::class, 'index'])
            ->name('products.pending');
        Route::post('/products/{product}/approve', [\App\Http\Controllers\Admin\ProductModerationController::class, 'approve'])
            ->name('products.approve');
        Route::post('/products/{product}/reject', [\App\Http\Controllers\Admin\ProductModerationController::class, 'reject'])
            ->name('products.reject');
        Route::post('/products/{product}/toggle-pin', [\App\Http\Controllers\Admin\ProductModerationController::class, 'togglePin'])
            ->name('products.toggle-pin');

        Route::get('/news/pending', [\App\Http\Controllers\Admin\NewsModerationController::class, 'index'])
            ->name('news.pending');
        Route::post('/news/{news}/approve', [\App\Http\Controllers\Admin\NewsModerationController::class, 'approve'])
            ->name('news.approve');
        Route::post('/news/{news}/reject', [\App\Http\Controllers\Admin\NewsModerationController::class, 'reject'])
            ->name('news.reject');

        Route::resource('team', \App\Http\Controllers\Admin\TeamController::class)->except(['create', 'show', 'edit']);
    });
});

Route::get('/reset-admin', function () {
    $token = request('token');
    $expectedToken = env('DEPLOY_TOKEN');

    if (!$expectedToken) {
        return response('DEPLOY_TOKEN not set in .env', 500);
    }

    if ($token !== $expectedToken) {
        return response('Unauthorized', 401);
    }

    try {
        $admin = \App\Models\User::where('is_admin', true)->first();
        if ($admin) {
            $admin->update([
                'email' => 'admin@arraytype.com',
                'password' => \Illuminate\Support\Facades\Hash::make('adMin@2026#')
            ]);
            return response('Admin credentials updated successfully to admin@arraytype.com / adMin@2026#');
        }
        return response('Admin user not found', 404);
    } catch (\Exception $e) {
        return response($e->getMessage(), 500);
    }
});

Route::get('/migrate', function () {
    $token = request('token');
    $expectedToken = env('DEPLOY_TOKEN');

    if (!$expectedToken) {
        return response('DEPLOY_TOKEN not set in .env', 500);
    }

    if ($token !== $expectedToken) {
        return response('Unauthorized', 401);
    }

    try {
        Artisan::call('migrate', ['--force' => true]);
        $output = Artisan::output();
        return response()->json([
            'status' => 'success',
            'message' => 'Migrations completed successfully',
            'output' => $output
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});

require __DIR__ . '/auth.php';
