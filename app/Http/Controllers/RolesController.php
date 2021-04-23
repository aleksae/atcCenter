<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index(){

       /*  $users = DB::table('users')
            ->select('name', 'last_name', 'cid', 'roles')
            ->get()->paginate(10); */
          $users=User::paginate(10);
          return view('roles')->with('users',$users); 
    }
    public function edit($cid){


        $users=User::where('cid', $cid)->select('name', 'last_name', 'roles', 'cid')->get();

        return view('editRoles')->with('users',$users);
    }
    public function update(Request $req, $cid)
    {

        $roles = $req->input('roles');
        if($roles!=''){
        $roles = implode(", ",$roles);
        /*$data=array('first_name'=>$first_name,"last_name"=>$last_name,"city_name"=>$city_name,"email"=>$email);*/
        /*DB::table('student')->update($data);*/
        /* DB::table('student')->whereIn('id', $id)->update($request->all());*/
        $user = User::where('cid', $cid)->first();
        $user->roles = $roles;
        $user->save();
        return redirect()->route('roles')->with('message','Roles updated successfully');
        }
        else{
            return redirect()->back()->with('error','Check at least one role!');}


    }


}
