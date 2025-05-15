<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function assignRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|string'
        ]);

        if (!in_array($request->role, ['admin', 'instructor'])) {
            return response()->json(['message' => 'Invalid role'], 422);
        }

        $user->syncRoles([$request->role]);

        return response()->json([
            'message' => "Role '{$request->role}' assigned to user {$user->id}"
        ]);
    }
}
