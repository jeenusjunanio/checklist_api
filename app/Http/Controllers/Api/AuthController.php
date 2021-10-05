<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use Laravel\Socialite\Facades\Socialite;
use Session;
class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // for registering a user
    public function register(Request $request)
    {
        
        if ($request->type=='user') {
           
           $fields=$request->validate([
                    'first_name'=>'required|string',
                    'last_name'=>'required|string',
                    'email'=>'required|string|unique:users,email',
                    'password'=>'required|string|confirmed'
                ]);
           

           $user=User::create([
            'first_name'=>$fields['first_name'],
            'last_name'=>$fields['last_name'],
            'email'=>$fields['email'],
            'password'=>Hash::make($fields['password']),
            'is_admin'=>0
           ]);
           $role=Role::where('id',6)->first();
            $user->syncRoles($role);
           $token=$user->createToken('apptoken')->plainTextToken;

           $response=[
            'user' => $user,
            'token' =>$token
           ];

           return response()->json($response,201);

        }else if ($request->type=='company') {

            $fields=$request->validate([
                    'company_name'=>'required|string',
                    'email'=>'required|string|unique:users,email',
                    'password'=>'required|string|confirmed'
                ]);

            $user=User::create([
            'company_name'=>$fields['company_name'],
            'email'=>$fields['email'],
            'password'=>Hash::make($fields['password']),
            'is_admin'=>1
           ]);
           $role=Role::where('id',1)->first();
            $user->syncRoles($role);

            $token=$user->createToken('apptoken')->plainTextToken;

           $response=[
            'user' => $user,
            'token' =>$token
           ];

           return response()->json($response,201);

        }else{
            return response()->json([
                'message'=>'user type undefined'
            ],400);
        }
    }


    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return response()->json([
                'message'=>'logged out'
            ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        
           
           $fields=$request->validate([
                    'email'=>'required|string',
                    'password'=>'required|string'
                ]);
           // check mail
           $user=User::where('email',$fields['email'])->first();

           // check password
           if (!$user || !Hash::check($fields['password'],$user->password)) {
               return response()->json([
                'message'=>'Bad credentials'
            ],401);
           }

           $token=$user->createToken('apptoken')->plainTextToken;

           $response=[
            'user' => $user,
            'roles'=>$user->roles,
            'token' =>$token
           ];

           return response()->json($response,201);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle(Request $request)
    {
        $request->session()->put('type' , $request->type);
        $request->session()->save();
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback()
    {
        $type = Session::get('type');

        $guser = Socialite::driver('google')->stateless()->user();
        $user=User::where('email',$guser->email)->first();
        if (!$user) {
            $user= new User();
            if ($type=='company') {
                $is_admin=1;
                $rid=1;
                $user->company_name=$guser->name;
            }else if($type=='user'){
                $is_admin=0;
                $rid=6;
                $cname=explode(' ', $guser->name);
                $user->first_name=$cname[0];
                $user->last_name=$cname[1];
            }else{
                $is_admin=0;
                $rid=6;
                $cname=explode(' ', $guser->name);
                $user->first_name=$cname[0];
                $user->last_name=$cname[1];
            }
            
            $user->email=$guser->email;
            $user->provider_id=$guser->id;
            $user->is_admin=$is_admin;
            $user->email_verified_at = now();
            $user->save();

            $role=Role::where('id',$rid)->first();
            $user->syncRoles($role);
        }
         $token=$user->createToken('apptoken')->plainTextToken;

           $response=[
            'user' => $user,
            'token' =>$token
           ];

           return response()->json($response,201);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    protected function loginOrRegister($data)
    {
        $user=User::where('email',$data->email)->first();
        if (!$user) {
            $user= new User();
            $user->first_name=$data->name;
            $user->email=$data->email;
            $user->provider_id=$data->id;
            $user->email_verified_at = now();
            $user->save();

            $role=Role::where('id',1)->first();
            $user->syncRoles($role);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
