<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Session;
// use Excel;
use File;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Input;
use App\Employee;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('employee');
    }

    public function import(Request $request)
    {
        //validate the xls file
        $this->validate($request, array(
            'file' => 'required'
        ));

        if ($request->hasFile('file')) {
            $extension = File::extension($request->file->getClientOriginalName());
            if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {

                $path = $request->file->getRealPath();
                $data = Excel::load($path, function ($reader) {
                })->get();
                if (!empty($data) && $data->count()) {
                    $insert = array();
                    $error = array();
                    foreach ($data as $key => $value) {
                        if (!empty($value->full_name) && !empty($value->dob) && !empty($value->gender) && !empty($value->salary) && !empty($value->designation)) {
                            // $check_dob=$this->checkmydate($value->dob);
                            $float = floatval($value->salary); //Convert the string to a float
                            if ($float && intval($float) != $float) {
                                $insert[] = [
                                    'full_name' => $value->full_name,
                                    'dob' => $value->dob,
                                    'gender' => $value->gender,
                                    'salary' => $value->salary,
                                    'designation' => $value->designation,
                                    'import_date'=>date("Y-m-d"),
                                ];
                            }
                            $error[] = 'Row ' . $key . ' Salary should be decimal.';
                        } else {
                            if (empty($value->full_name)) {
                                $error[] = 'Row ' . $key . ' Full Name shouldnot be empty.';
                            }
                            if (empty($value->dob)) {
                                $error[] = 'Row ' . $key . ' Ethier dob is empty or dob is not in correct format.';
                            }
                            if (empty($value->gender)) {
                                $error[] = 'Row ' . $key . ' Gender shouldnot be empty.';
                            }
                            if (empty($value->salary)) {
                                $error[] = 'Row ' . $key . ' Salary shouldnot be empty.';
                            }
                            if (empty($value->designation)) {
                                $error[] = 'Row ' . $key . ' Designation shouldnot be empty.';
                            }
                        }
                    }
                    if (!empty($insert)) {

                        $insertData = DB::table('employees')->insert($insert);
                        if ($insertData) {
                            Session::flash('success', 'Your Data has successfully imported');
                        } else {
                            Session::flash('error', 'Error inserting the data..');
                            return back();
                        }
                    }
                }

                return back()->withErrors($error);

            } else {
                Session::flash('error', 'File is a ' . $extension . ' file.!! Please upload a valid xls/csv file..!!');
                return back();
            }
        }
    }

    public function checkmydate($date)
    {
        $tempDate = explode('-', $date);
  // checkdate(month, day, year)
        return checkdate($tempDate[1], $tempDate[2], $tempDate[0]);
    }

    public function store(Request $request)
    {
        $this->validate($request, array(
            'full_name' => ['required', 'string', 'max:255'],
            'dob' => 'required|date',
            'salary' => 'required|numeric|between:0,1000000.99',
            'designation' => 'required',
            'gender' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ));
        $input = $request->all();
        // print_r($input);
        // die();
        $input['import_date']=date("Y-m-d");
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $imagePath = $destinationPath . "/" . $name;
            $image->move($destinationPath, $name);
            $input['image'] = $name;
        }
        unset($input['_token']);
        if (!empty($input)) {
            $insertData = DB::table('employees')->insert($input);
            if ($insertData) {
                Session::flash('success', 'Your Data has successfully inserted');
            } else {
                Session::flash('error', 'Error inserting the data..');
                return back();
            }
        }
        return back();
    }

    public function update(Request $request)
    {
        $this->validate($request, array(
            'full_name' => ['required', 'string', 'max:255'],
            'dob' => 'required|date',
            'salary' => 'required|numeric|between:0,1000000.99',
            'designation' => 'required',
            'gender' => 'required',
        ));
        $input = $request->all();
        $id = $request->get('id');
        
        $users = DB::table('employees')->where('id', $id)->first();
        if ($id) {
            if ($request->hasFile('image')) {
                if(!empty($users->image)){
                    $usersImage = public_path("images/{$users->image}"); // get previous image from folder
                    if (File::exists($usersImage)) { // unlink or remove previous image from folder
                        unlink($usersImage);
                    }
                }
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/images');
                $imagePath = $destinationPath . "/" . $name;
                $image->move($destinationPath, $name);
                $input['image'] = $name;
            }
            $input['updated_at']=date("Y-m-d");
            unset($input['_token']);
            if (!empty($input)) {
                $insertData = DB::table('employees')->where('id', $id)->update($input);
                if ($insertData) {
                    Session::flash('success', 'Your Data has successfully inserted');
                } else {
                    Session::flash('error', 'Error inserting the data..');
                    return back();
                }
            }
        } else {
            Session::flash('error', 'Error inserting the data..');
        }
        return redirect()->route('employee');
    }

    public function edit($id = false)
    {
        $data = DB::table('employees')->where('id', $id)->first();
        return view('editform')->with('id', $id)->with('data', $data);
    }

    public function save()
    {
        return view('saveform');
    }

    public function list(Request $request)
    {
        $data = Employee::get_list();
        $array = array();
        $filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);
        $totalrecs = $data["totalrecs"];
        unset($data["totalfilteredrecs"]);
        unset($data["totalrecs"]);

        $i = 0;
        $array = array();
        foreach ($data as $key => $row) {
            $array[$i]['id'] = $row->id;
            $array[$i]['full_name'] = $row->full_name;
            $array[$i]['dob'] = $row->dob;
            $array[$i]['gender'] = $row->gender;
            $array[$i]['salary'] = $row->salary;
            $array[$i]['designation'] = $row->designation;
            $array[$i]['select'] = '<td></td>';
            $array[$i]['action'] ='<a href="/edit/'.$row->id.'"><i class="fa fa-edit"></i></a>
            &nbsp';
            $i++;
        }
        return response()->json(["recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, 'data' => $array]);
    }


}
