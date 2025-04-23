<?php
// require base_path('routes/api.php'); 
// use App\Models\User;
// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\PagesController;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Hash;
// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', [PagesController::class, 'index']);
// Route::get('/about', [PagesController::class, 'about']);
// Route::get('/services', [PagesController::class, 'services']);

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

Route::get('/setup', function() {
    try {
        Log::info('Setup route started'); // Check storage/logs/laravel.log
        
        $credentials = [
            'email' => 'admin@admin.com',
            'password' => 'password'
        ];

        // Check if user already exists
        if (User::where('email', $credentials['email'])->exists()) {
            return response()->json(['error' => 'User already exists'], 400);
        }

        // Create user
        $user = User::create([
            'name' => 'Admin',
            'email' => $credentials['email'],
            'password' => Hash::make($credentials['password'])
        ]);

        // Generate tokens
        $adminToken = $user->createToken('admin-token', ['create', 'update', 'delete']);
        $updateToken = $user->createToken('update-token', ['update']);
        $basicToken = $user->createToken('basic-token');

        return response()->json([
            'admin' => $adminToken->plainTextToken,
            'update' => $updateToken->plainTextToken,
            'basic' => $basicToken->plainTextToken,
        ]);

    } catch (\Exception $e) {
        Log::error('Setup failed: '.$e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

Route::get('/debug', function() {
    // Test database
    try {
        DB::connection()->getPdo();
        echo "DB Connected: ".DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        die("DB Error: ".$e->getMessage());
    }

    // Test auth
    if (!class_exists('Auth')) {
        die("Auth facade missing");
    }

    return "All systems go!";
});