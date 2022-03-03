<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class userController extends Controller
{


    public function __construct()
    {
       $this->middleware('checkLogin', ['except' => ['create','login','doLogin','logout']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::get();
        return view('user.index', ['data'=> $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /// validate inputs
        $data = $this->validate($request, [
            'name'     => 'required|min:3',
            'username' => 'required|min:3',
            'email'    => 'required|email',
            'password' => 'required|min:6|max:50'
        ]);

        /// override password w encrypted passwerd
        $data['password'] = bcrypt($data['password']);

        /// store data in db
        $op = User::create($data);

        ///check if process happened or not
        if($op){
            $message = 'data inserted';
        }else{
            $message =  'error try again';
        }

        session()->flash('message', $message);
        return view('user.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /// fetch data from db and send it to view edit
        $data = User::find($id);
        return view('user.edit', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /// validate inputs
        $data = $this->validate($request, [
            'name'     => 'required|min:3',
            'username' => 'required|min:3',
            'email'    => 'required|email'
        ]);

        $op = User:: where('id',$id)->update($data);

        if($op){
           $message = 'Raw Updated';
       }else{
           $message =  'error try again';
       }

       session()->flash('message',$message);

       return redirect(url('/user/'));

    }


    public function login(){
        return view('user.login');
    }



    public function doLogin(Request $request){

     $data =  $this->validate($request,[
         'username'  => 'required|min:3',
         'password' => 'required|min:6|max:50'
       ]);


       if(auth()->attempt($data)){

        return redirect(url('/task'));

       }else{
           session()->flash('message','invalid Data');
           return redirect(url('/user/login'));
       }


    }


    public function logout(){
        // code .....

        auth()->logout();
        return redirect(url('/user/login'));
    }


}
