<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
 use Intervention\Image\Facades\Image;  
use Illuminate\Validation\rule;

class usercontroller extends Controller
{
    public function __construct(){

       $this->middleware('permission:read_users')->only('index');
      $this->middleware('permission:create_users')->only('create');
       $this->middleware('permission:update_users')->only('edit');
       $this->middleware('permission:delete_users')->only('destroy');
    }

    public function index(request $request){
              
       $users= User::whereRoleIs('admin')->where(function($q) use($request){

       return $q->when($request->search,function($query)use($request){

            return $query->where('first_name','like','%'.$request->search .'%')
                     ->orwhere('last_name','like','%'.$request->search .'%');

           });
       })->latest()->paginate(5);
       
       
     
        return view('dashboard.users.index',compact('users'));
    }

    public function create(){

       
         return view('dashboard.users.create');
     }

   public function store(request $request){
        
       $request->validate([
              'first_name'=>'required',
              'last_name'=>'required',
              'email'=>'required|unique:users',
              'password'=>'required|confirmed',
              'image'=>'image',
              'permissions'=>'required',
              
       ]);
      
      $request_data=$request->except('password','password_confirmation','permissions','image');

      $request_data['password']=bcrypt($request->password);
      if($request->image)
       {
           $imagename=$request->image->hashname();

              Image::make($request->image)->resize(300, null, function ($constraint)
            {               
                $constraint->aspectRatio();
            })->save(public_path('uploads/users_images/'.$imagename));
            $request_data['image']=$imagename;
       }

      $user=User::create($request_data);

      $user->attachRole('admin');// equivalent to $user->roles()->attach('admin');
     
      $user->syncPermissions($request->permissions);// equivalent to $user->permissions()->sync($request->permissions);
      
      session()->flash('success',__('site.added_successfully'));
        return redirect()->route('dashboard.users.index');
       
    }


    public function edit(User $user){
        
       
        return view('dashboard.users.edit',compact('user'));
    }


    public function update(request $request,User $user){
        
        $request->validate([
               'first_name'=>'required',
               'last_name'=>'required',
               'email'=>['required', Rule::unique('users')->ignore($user->id)],
               'image'=>'image',
               'permissions'=>'required|min:1',
               
              
        ]);
       
       $request_data=$request->except('permissions');
       if($request->image)
       {
           $imagename=$request->image->hashname();
           if($user->image !='default.jpg'){

            $image=public_path('uploads/users_images').'/'.$user->image;
             unlink($image);

           }

              Image::make($request->image)->resize(300, null, function ($constraint)
            {               
                $constraint->aspectRatio();
            })->save(public_path('uploads/users_images/'.$imagename));
            $request_data['image']=$imagename;
       }
 
        
       $user->update($request_data);
       
      
       $user->syncPermissions($request->permissions);// equivalent to $user->permissions()->sync($request->permissions);
       
       session()->flash('success',__('site.updated_successfully'));
         return redirect()->route('dashboard.users.index');
        
     }


     public function destroy(User $user){

          
        $user->delete();
        if($user->image !='default.jpg')
        {
          $image=public_path('uploads/users_images').'/'.$user->image;
           unlink($image);

        }
       
       
        session()->flash('success',__('site.deleted_successfully'));
        return redirect()->route('dashboard.users.index');
     }
 
}
