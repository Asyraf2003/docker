<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PpdbController;
use App\Models\GalleryImage;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Models\Announcement;
use App\Models\Program;
use App\Models\Extracurricular;
use App\Models\Event;
use App\Http\Controllers\SecurityController;

Route::middleware(['auth'])->group(function () {
    Route::get('/security/2fa', [SecurityController::class, 'twoFactor'])->name('security.2fa');
});

// ===== Language switch
Route::get('/lang/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'id', 'ar'])) {
        abort(400);
    }
    session()->put('locale', $locale);
    // Jika tidak ada referer, fallback ke home
    return redirect()->back() ?: redirect()->route('home');
})->name('lang.switch');

// ===== Sitemap
Route::get('/sitemap.xml', fn() =>
    response()->view('sitemap')->header('Content-Type','application/xml')
);

// ===== Articles
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])
    ->where('slug', '[A-Za-z0-9\-]+')
    ->name('article');

Route::post('/articles/{articleId}/like', [LikeController::class, 'toggle'])
    ->whereNumber('articleId')
    ->middleware('throttle:30,1')
    ->name('articles.like');

Route::post('/articles/{article}/comments', [CommentController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('comments.store');
    
    Route::middleware(['auth', 'can:moderate,App\Models\Comment'])->group(function () {
    Route::patch('/comments/{comment}/moderate', [CommentController::class, 'moderate'])
        ->name('comments.moderate');
});

// ===== Home
Route::get('/', function () {
    $gallery = GalleryImage::published()->take(12)->get();
    $announcements = Announcement::published()->ordered()->take(9)->get();
    $programs = Program::published()->ordered()->take(8)->get();
    $ekstra = Extracurricular::published()->ordered()->get();
    $events = Event::published()->ordered()->take(6)->get();

    return view('welcome', compact('gallery', 'announcements', 'programs', 'ekstra', 'events'));
})->name('home');

// ===== PPDB (hanya untuk user login)
Route::middleware(['web', 'auth', 'verified'])->group(function () {
    Route::get('/ppdb', [PpdbController::class, 'create'])->name('ppdb.create');
    Route::post('/ppdb', [PpdbController::class, 'store'])
        ->middleware('throttle:4,1')
        ->name('ppdb.store');
});

// ===== Dashboard redirector
Route::get('/dashboard', function (Request $request) {
    $user = $request->user();
    return match ($user->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'user'  => redirect()->route('user.dashboard'),
        'other' => redirect()->route('other.dashboard'),
        default => abort(403),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

// ===== Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===== Authentication & Role-based routes
require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/user.php';
require __DIR__.'/other.php';