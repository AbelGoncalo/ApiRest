<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Models\{User};
use App\Http\Resources\UserResource;
use App\Http\Requests\{StoreUpdateUserRequest};


class UserController extends Controller
{
    //

    public function index(){

        $user = User::paginate();

        return UserResource::collection($user);
    }

    public function store(Request $request){

        //$data =   $request->validate(); 
        
        $this->validate($request,[
            'name'=>'required|min:3|max:255',
            'email'=>[
                'required',
                'email',
                'max:255',
                'unique:users'
            ],
            'password'=>[
            'required',
            'min:6',
            'max:100'
            ]
        ]);

        $data = $request->all();

        $data['password']= bcrypt($request->password);

        $user = User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>$data['password']
        ]);


        return new UserResource($user);
     
    }

    public function show(string $id){

        
        
        $user = User::find($id);

        if(!$user){

             return response()->json(['message'=>'user not found'], 400);
        }

        return new UserResource($user);


    }

    public function update(Request $request, string $id){

        $this->validate($request,[
           
            'email'=>[
                'required',
                'email',
                'max:255',
                //Rule::unique('users')->ignore($this->id),
                "unique:users,email,{$id},id"

            ],
            'password'=>[
                'nullable',
                'min:6',
                'max:100'
            ]
        ]);

        if($data['password']){
            $data['password']= bcrypt($request->password);
        }

        $data = $request->all();
        $user = User::findOrFail($id);
        $user->update($data);

        return new UserResource($user);

    }

    public function destroy(string $id){

        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([], 204);
    }
}
