<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Region;
use App\Models\Role;
use App\Models\State;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Helper;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
        $roles = Role::all();
        $data = [
            'roles' => $roles
        ];
        return view('backend.pages.user.index', $data);
    }

    public function getList(Request $request){

        $data = User::query()->orderBy('created_at', 'desc');
        if ($request->name) {
            $data->where(function($query) use ($request){
                $query->where('name','like', "%" .$request->name ."%" );
            });
        }

        if ($request->email) {
            $data->where(function($query) use ($request){
                $query->where('email','like', "%" .$request->email ."%" );
            });
        }

        if ($request->phone) {
            $data->where(function($query) use ($request){
                $query->where('phone','like', "%" .$request->phone ."%" );
            });
        }
        if ($request->role) {
            $data->where(function($query) use ($request){
                $query->where('role', $request->role);
            });
        }


        return Datatables::of($data)

        ->editColumn('profile_image', function ($row) {
            return ($row->profile_image) ? '<img class="profile-img" src="'.asset('uploads/user-images/'.$row->profile_image).'" alt="profile image">' : '<img class="profile-img" src="'.asset('assets/img/no-img.jpg').'" alt="profile image">';
        })

        ->editColumn('name', function ($row) {
            return '<a href="'.route('admin.user.details', ['id' => $row->id]).'">' .$row->name. '</a>';
        })

        ->editColumn('role', function ($row) {
            return optional($row->roles)->name;
        })

        ->editColumn('status', function ($row) {
            if ($row->status == 1) {
                return '<span class="badge bg-success-200 text-success-700 rounded-pill w-80">Active</span>';
            }else{
                return '<span class="badge bg-gray-200 text-gray-600 rounded-pill w-80">Inactive</span>';
            }
        })

        ->addColumn('action', function ($row) {
            $btn = '';
            // if (Helper::hasRight('user.edit')) {
                $btn = $btn . '<a href="" data-id="'.$row->id.'" class="edit_btn btn btn-sm text-gray-900"><i class="fa-solid fa-pencil"></i></a>';
            // }
            // if (Helper::hasRight('user.edit')) {
                // $btn = $btn . '<a class="change_password btn btn-sm text-gray-900 mx-1 " data-id="'.$row->id.'" href="" title="Change Password"><i class="fa-solid fa-key"></i></a>';
            // }
            // if (Helper::hasRight('user.delete')) {
                $btn = $btn . '<a class="delete_btn btn btn-sm text-gray-900" data-id="'.$row->id.'" href=""><i class="fa fa-trash" aria-hidden="true"></i></a>';
            // }
            return $btn;
        })
        ->rawColumns(['profile_image','name','role','status','action'])->make(true);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'profile_image' => 'required|image|mimes:jpg,png|max:20480'
		], [
            'phone.unique' => 'This phone number has already been taken.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'type' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->gender = $request->gender;
        $user->address = $request->address;

        $user->password = Hash::make($request->password);
        $user->visible_password = $request->password;

        $user->status  = ($request->status) ? 1 : 0;
        $user->role = $request->role;

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $filename = time() . uniqid() . $image->getClientOriginalName();
            $image->move(public_path('uploads/user-images'), $filename);
            $user->profile_image = 'uploads/user-images/' . $filename;
        }
        if ($user->save()) {
            return response()->json([
                'type' => 'success',
                'message' => 'User created successfully.',
            ]);
        }
    }

    public function edit($id){
        $user = User::find($id);
        $roles = Role::all();

        $data = [
            'user' => $user,
            'roles' => $roles
        ];

        return view('backend.pages.user.edit', $data);
    }

    public function update(Request $request, $id){
        $validator = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'nullable',
            'gender' => 'required',
            'address' => 'nullable',
            'profile_image' => 'image|mimes:jpg,png|max:20480'
		]);

        $user = User::find($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->gender = $request->gender;
        $user->address = $request->address;

        $user->password = Hash::make($request->password);
        $user->visible_password = $request->password;

        $user->status  = ($request->status) ? 1 : 0;
        $user->role = $request->role;

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image != Null && file_exists(public_path($user->profile_image))) {
                unlink(public_path($user->profile_image));
            }
            $image = $request->file('profile_image');
            $filename = time() . uniqid() . $image->getClientOriginalName();
            $image->move(public_path('uploads/user-images'), $filename);
            $user->profile_image = 'uploads/user-images/' . $filename;
        }

        if ($user->save()) {
            return response()->json([
                'type' => 'success',
                'message' => 'User updated successfully.',
            ]);
        }else{
            return response()->json([
                'type' => 'success',
                'message' => 'Something went wrong.',
            ]);
        }
    }

    public function delete($id){
        $user = User::find($id);
        if($user){
            if ($user->profile_image != Null && file_exists(public_path($user->profile_image))) {
                unlink(public_path($user->profile_image));
            }
            $user->delete();
            return json_encode(['success' => 'User deleted successfully.']);
        }else{
            return json_encode(['error' => 'User not found.']);
        }
    }

    public function changePassword(Request $request){
        $validator = $request->validate([
			'password' => 'required|min:8|confirmed',
			'password_confirmation' => 'required'
		]);

        $user = User::find($request->user_id);
        if($user){
            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json([
                'type' => 'success',
                'message' => 'User password changed successfully.',
            ]);
        }else{
            return response()->json([
                'type' => 'error',
                'message' => 'User not found.',
            ]);
        }
    }

    public function userDetails($id){
        $user = User::find($id);
        $regions = Region::all();
        $data = [
            'user' => $user,
            'regions' => $regions
        ];
        return view('backend.pages.user.user_details', $data);
    }
}
