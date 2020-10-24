<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users=User::paginate(2);

       return view('users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

       return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {

        $rules = [
            'name' => 'required|string|min:4',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:3',
            'phone' => 'required',
            'role'=>  'required'
        ];

        $messages = [
            'email.required'    => trans("email.required"),
            'email.email'       => trans("email.unique"),
            'email.unique'      => trans("name.required"),
            'password.required' => trans("password.required"),
            'password.min'      => trans("password.min"),
            'name.required'     => trans("name.required"),
            'phone.required'    => trans("phone.required"),
        ];

        $request->validate($rules,$messages);

        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->password);
        $user->phone = $request->input('phone');
        $user->role = $request->input('role');

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
         //  $pagination=User::paginate(2);

         // return view('users.index', compact('pagination'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
     public function edit($id) {
        $content = User::find($id);
        return view ('users.edit',compact('content'));

    }



    public function update(Request $request, $id) {
        $user = User::find($id);
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->phone    = $request->phone;
        $user->role     = $request->role;
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('admin.users.index')->with('success',trans('user.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {

         User::find($id)->delete();

        return redirect()->route('admin.users.index');

        $content= User::find($id);
        $content->delete();
        return redirect()->route('admin.users.index')->with('success',trans('user.deleted'));

    }
}
