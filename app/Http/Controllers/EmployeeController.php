<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('employee.index');
    }

    // store data
    public function store(Request $request)
    {
        $file = $request->file('avatar');
		$fileName = time() . '.' . $file->getClientOriginalExtension();
		$file->storeAs('public/image', $fileName);
        $emp = [
            'firstname'=>$request->fname,
            'lastname'=>$request->lname,
            'post'=>$request->post,
            'email'=>$request->email,
            'photo'=>$fileName,
        ];
        Employee::create($emp);
        return response()->json([
            'status'=>200
        ]);
    }

    // fetchAll data
    public function fetchAll()
    {
        $emps = Employee::all();
        $output='';
        if($emps-> count() > 0)
        {
            $output .= '<table class="table table-bordered table-sm text-center align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Avatar</th>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Post</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>';
                    foreach($emps as $emp){
                    $output .= '<tr>
                                    <td>' . $emp->id. '</td>
                                    <td><img src="storage/image/' . $emp->photo . '" width="50" class="img-thumbnail rounded-circle"></td>
                                    <td>' . $emp->firstname. '</td>
                                    <td>' . $emp->lastname. '</td>
                                    <td>' . $emp->post. '</td>
                                    <td>' . $emp->email. '</td>
                                    <td>
                                    <a href="#" id="' . $emp->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"><i class="bi-pencil-square h4"></i></a>
                  
                                    <a href="#" id="' . $emp->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                                  </td>

                                </tr>';
                    }
                    $output .= '</tbody></table>';
                    echo $output;
        }
    }
    // edit data
    public function edit(Request $request)
    {
        $id = $request->id;
        $emp = Employee::find($id);
        return response()->json($emp);
    }

    // update data
    public function updated(Request $request)
    {
        $filename = '';
        $emp = Employee::find($request->emp_id);
        if($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $filename = time(). '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/image/' ,$filename);
            if($emp-> avatar){
                Storage::delete('public/images/' .$emp->avatar);
            }
        }
        else{
            $filename = $request->emp_avatar;
        }
      
        $empData = [
            'firstname'=>$request->fname,
            'lastname'=>$request->lname,
            'post'=>$request->post,
            'email'=>$request->email,
            'photo'=>$filename,
        ];

        $emp->update($empData);
        return response()->json([
            'status'=>200
        ]);
    }

    // delete data

    public function delete(Request $request)
    {
        $id = $request->id;
        $emp = Employee::find($id);
      
        Employee::destroy($id);
    }


}
