<?php

namespace App\Http\Controllers;

use App\Models\Api\Student;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Traits\HttpResponseFormatter;
class AuthController extends Controller
{
    use HttpResponseFormatter;
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users',
            'password' => 'required|string',
            'c_password' => 'required|same:password'
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        if ($user->save()) {
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->plainTextToken;
            // dd($user->id);
            Student::create([
                'student_name' => $request->name,
                'student_email' => $request->email,
            ]);
            $userDetails = User::join('students', 'students.student_email', '=', 'users.email')
            ->where('users.id', $user->id)
            ->select('users.*', 'students.*', 'students.id as student_id')
            ->first();
            return $this->success("Successfully registered", [
                'accessToken' => $token,
                'user' => $userDetails
            ]);
        } else {
            return response()->json(['error' => 'Provide proper details']);
        }
    }

    public function test(){
        return response()->json([
            'message' => 'Test'
        ]);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return $this->failure("Invalid Credentials");
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->plainTextToken;
        $userDetails = User::join('students', 'students.student_email', '=', 'users.email')
            ->where('users.id', $user->id)
            ->select('users.*', 'students.*', 'students.id as student_id')
            ->first();
        return $this->success("Successfully logged in", [
            'accessToken' => $token,
            'user' => $userDetails
        ]);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function checkAuth(Request $request){
        if(Auth::check()){
            return $this->success("User is logged in", Auth::user());
        }else{
            return $this->failure("User is not logged in");
        }
    }

    public function notLogin(){
        return $this->failure("User is not logged in");
    }

}
