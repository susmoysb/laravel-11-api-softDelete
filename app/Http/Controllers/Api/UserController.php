<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::query();
        if ($request->has('with_trashed')) {
            $users = $users->withTrashed();
        }

        return response()->json([
            'status' => 'success',
            'data' => $users->get(),
            'message' => 'Users retrieved successfully.',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json([
            'status' => 'success',
            'data' => $user,
            'message' => 'User retrieved successfully.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->delete()) {
            return response()->json([
                'status' => 'success',
                'data' => $user,
                'message' => 'User deleted successfully.',
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'User deletion failed.',
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * uses route model binding to automatically inject the User model instance corresponding to the provided user ID.
     * route model binding for trashed models is enabled by chaining the withTrashed() method to the route definition.
     */
    public function restore(User $user)
    {
        if ($user->trashed() && $user->restore()) {
            return response()->json([
                'status' => 'success',
                'data' => $user,
                'message' => 'User restored successfully.',
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'User restoration failed.',
        ]);
    }
}
