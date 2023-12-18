<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\HttpResponseFormatter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use HttpResponseFormatter;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = $request->user_id;
        $user = User::where('id', $userId)->first();
        $user = User::join('students', 'students.student_email', '=', 'users.email')
            ->where('users.id', $userId)
            ->select('users.*', 'students.*')
            ->first();
        if($user){
            return $this->success("User Fetched", $user);
        }
        return $this->failure("User Not Fetched");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {

        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8'
        ]);
        // dd($request->all());
        $userId = auth()->id();
        $oldPassword = $request->old_password;
        $newPassword = $request->password;
        $confirmPassword = $request->confirm_password;

        

        if ($newPassword !== $confirmPassword) {
            return $this->failure("Password and Confirm Password do not match");
        }

        $user = User::where('id', $userId)->first();
        // dd($user);
        // dd(Hash::check($oldPassword, $user->password));
        if ($user && Hash::check($oldPassword, $user->password)) {
            $user->password = bcrypt($newPassword);
            if ($user->save()) {
                return $this->success("Password Updated");
            }
            return $this->failure("Password Not Updated");
        }

        return $this->failure("Old Password is incorrect");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
