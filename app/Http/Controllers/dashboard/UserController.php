<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;




class UserController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        //create read update delete
        return [
            'auth',
            new Middleware(['permission:users_read'], only: ['index']),
            new Middleware(['permission:users_create'], only: ['create']),
            new Middleware(['permission:users_update'], only: ['edit']),
            new Middleware(['permission:users_delete'], only: ['destroy']),

        ];
    } //end of constructor

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::whereHasRole('admin')->where(function ($q) use ($request) {

            return $q->when($request->search, function ($query) use ($request) {

                return $query->where('first_name', 'like', '%' . $request->search . '%')
                    ->oWhere('last_name', 'like', '%' . $request->search . '%');
            });
        })->latest()->paginate(5);

        return view('dashboard.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'first_name' => 'required',
    //         'last_name' => 'required',
    //         'email' => 'required|unique:users',
    //         'image' => 'image',
    //         'password' => 'required|confirmed',
    //         'permissions' => 'required|min:1'
    //     ]);

    //     $request_data = $request->except(['password', 'password_confirmation', 'permissions', 'image']);
    //     $request_data['password'] = bcrypt($request->password);

    //     if ($request->image) {
    //         $imagePath = $request->image->store('uploads/user_images', 'public');

    //         $image = app('image')->make(public_path("storage/{$imagePath}"))
    //             ->resize(300, null, function ($constraint) {
    //                 $constraint->aspectRatio();
    //             })
    //             ->save();

    //         $request_data['image'] = basename($image->basename);
    //     }


    //     $user = User::create($request_data);
    //     $user->addRole('admin');
    //     $user->syncPermissions($request->permissions);

    //     session()->flash('success', __('site.added_successfully'));
    //     return redirect()->route('dashboard.users.index');
    // }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users',
            'image' => 'image',
            'password' => 'required|confirmed',
            'permissions' => 'required|min:1',
            'permissions.*' => 'string|exists:permissions,name',

        ]);

        $request_data = $request->except(['password', 'password_confirmation', 'permissions', 'image']);
        $request_data['password'] = bcrypt($request->password);

        if ($request->image) {

            Image::read($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('uploads/user_images/' . $request->image->hashName()));

            $request_data['image'] = $request->image->hashName();
        } //end of if

        $user = User::create($request_data);

        $role = Role::where('name', 'admin')->first();
        // Assign the role 'admin' to the user
        $user->addRole($role);


        // Sync the permissions to the user
        if ($request->has('permissions')) {
            $user->givePermissions($request->permissions);
        }

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.users.index');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('dashboard.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, User $user)
    // {
    //     $request->validate([
    //         'first_name' => 'required',
    //         'last_name' => 'required',
    //         'email' => ['required', Rule::unique('users')->ignore($user->id),],
    //         'image' => 'image',
    //         'permissions' => 'required|min:1'
    //     ]);

    //     $request_data = $request->except(['permissions', 'image']);

    //     if ($request->image) {

    //         if ($user->image != 'default.png') {

    //             Storage::disk('public_uploads')->delete('/user_images/' . $user->image);
    //         } //end of inner if

    //         Image::read($request->image)
    //             ->resize(300, null, function ($constraint) {
    //                 $constraint->aspectRatio();
    //             })
    //             ->save(public_path('uploads/user_images/' . $request->image->hashName()));

    //         $request_data['image'] = $request->image->hashName();
    //     } //end of external if

    //     $user->update($request_data);

    //     if ($request->has('permissions')) {
    //         $user->givePermissions($request->permissions);
    //     }
    //     session()->flash('success', __('site.updated_successfully'));
    //     return redirect()->route('dashboard.users.index');
    // }
    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => "required|unique:users,email,{$user->id}", // Exclude current user from unique validation
            'image' => 'image',
            'password' => 'nullable|confirmed', // Password is optional in update
            'permissions' => 'required|min:1',
            'permissions.*' => 'string|exists:permissions,name',


        ]);

        $request_data = $request->except(['password', 'password_confirmation', 'permissions', 'image']);

        if ($request->password) {
            $request_data['password'] = bcrypt($request->password);
        }

        if ($request->image) {
            if ($user->image && file_exists(public_path('uploads/user_images/' . $user->image))) {
                unlink(public_path('uploads/user_images/' . $user->image)); // Delete old image
            }

            Image::read($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('uploads/user_images/' . $request->image->hashName()));

            $request_data['image'] = $request->image->hashName();
        }

        $user->update($request_data);

        $role = Role::where('name', 'admin')->first();
        $user->syncRoles([$role->name]);

        // Sync the user's permissions
        if ($request->has('permissions')) {
            $user->syncPermissions($request->permissions);
        }

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.users.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->image != 'default.png') {

            Storage::disk('public_uploads')->delete('/user_images/' . $user->image);
        } //end of if

        $user->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.users.index');
    } //end of destroy


}//end of controller
