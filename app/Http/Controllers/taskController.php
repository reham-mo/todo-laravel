<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class taskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Task::join('users', 'users.id', '=', 'tasks.user_id')->select('tasks.*', 'users.id as userId')->get();
        return view('task.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('task.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ///validate entered data
        $data = $this->validate($request,[
            'title'   => 'required|max:100',
            'content' => 'required|max:255',
            'image'   => 'required|image|mimes:jpg,png,jpeg,gif',
            'start_date'   => 'required|date|before:end_date',
            'end_date'   => 'required|date|after:start_date'
        ]);

        /// rename image
        $finalName = time() . rand() . '.' . $request->image->extension();

        /// try to upload the image
        /// A- successful
        if($request->image->move(public_path('images'), $finalName)){
            $data['image'] = $finalName;
            $data['user_id'] = auth()->user()->id;

            $op = Task::create($data);
            if($op){
                $message = "raw inserted";
            }else{
                $message = "error try again";
            }


        }else{
            $message = " error in uploading the image!! try again!!";
        }

        session()->flash('message', $message);
        return redirect(url('/task'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Task::find($id);
        return view('task.edit', ['data' => $data]);
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
        ///validate updated inputs
        $data = $this->validate($request,[
            'title'      => 'required|max:100',
            'content'    => 'required|max:255',
            'image'      => 'nullable|image|mimes:jpg,png,jpeg,gif',
            'start_date' => 'required|date|before:end_date',
            'end_date'   => 'required|date|after:start_date'
        ]);

        ///fetch data
        $objData = Task::find($id);

        if ($request->hasFile('image')) {

            $FinalName = time() . rand() . '.' . $request->image->extension();

            if ($request->image->move(public_path('images'), $FinalName)) {

                unlink(public_path('images/' . $objData->image));
            }
        } else {
            $FinalName = $objData->image;
        }


        $data['image'] = $FinalName;

        # Update OP ...
        $op = Task::find($id)->update($data);

        if ($op) {
            $message = 'Raw Updated';
        } else {
            $message =  'error try again';
        }

        session()->flash('message', $message);

        return redirect(url('/task'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /// find data of id to get image so i can delete later
        $data = Task::find($id);

        /// delete data of id
        $op = Task::find($id)->delete();
        if ($op) {
            /// delete image from my app
            unlink(public_path('images/' . $data->image));
            $message = "Raw Removed";
        } else {
            $message = "Error Try Again";
        }

        session()->flash('message', $message);

        return redirect(url('/task'));
    }

}
