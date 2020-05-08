<?php

namespace App\Http\Controllers;

use App\Models\UserRoles;
use App\Models\Role;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserRoleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;


class UserController extends Controller
{
    /**
     * Return User Role
     * 
     * @param int $id
     * @return \App\Models\UserRoles
     */
    public function userRole($id){
        $schema = UserRoles::where(['user_id' => $id])
            ->join('roles','roles.id','role_id');

        return $schema;
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index');
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
    public function store(UserRequest $request)
    {
        $user = new User( $request->all() );
        
        if($user->save()){
            return redirect()
                ->route('user.show', $user)
                ->with('success', 'User berhasil ditambahkan.');
        }else{
            return redirect()
                ->route('user.index')
                ->with('error', 'User gagal ditambahkan.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $roles = $this->userRole($user->id)
            ->select(['user_roles.id','roles.nama','user_roles.created_at'])
            ->get();

        return view('user.show', compact('user', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        if($user->update( $request->all() )){
            return redirect()
                ->route('user.show', $user)
                ->with('success', 'User berhasil diubah.');
        }else{
            return redirect()
                ->route('user.index')
                ->with('error', 'User gagal diubah.');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $checkUserLogin = auth()->user()->id === $user->id;

        if($checkUserLogin){
            return redirect()
                ->route('user.index')
                ->with('error', 'Tidak dapat menjalankan aksi ini kepada user yang sedang aktif.');
        }else{
            DB::beginTransaction();
            try{
                $user->delete();
                DB::commit();
                return redirect()
                    ->route('user.index')
                    ->with('success', 'User berhasil dihapus.');
            }catch(\Exception $e){
                DB::rollback();
                return redirect()
                    ->route('user.index')
                    ->with('error', "User gagal dihapus. Masih ada data yang ter-relasi dengan data ini.");
            }
        }
    }


    /**
     * display form add role
     * 
     * @param App\Models\User
     * @return Illuminate\Http\Response
     */
    public function addRole(User $user){
        $roles = Role::select(['id','nama'])
            ->get();

        return view('user.roles.create', compact('user', 'roles'));
    }

    /**
     * stored user role
     * 
     * @param App\Http\Requests\UserRoleRequest
     * @param App\Models\User
     * @return Illuminate\Http\Response
     */
    public function storeRole(UserRoleRequest $request,User $user){

        $checkURole = $this->userRole($user->id)
            ->select(['roles.id'])
            ->get();

        $haveRole = false;

        foreach($checkURole as $roles)
            if($request->roles == $roles->id)
                $haveRole = true;

        if($haveRole){
            return redirect()
                ->route('user.show', $user)
                ->with('error', 'Role telah dipunyai user.');
        }else{

            $userRole = new UserRoles([
                'user_id' => $user->id,
                'role_id' => $request->roles
            ]);

            if( $userRole->save() ){
                return redirect()
                    ->route('user.show', $user)
                    ->with('success', 'Role berhasil ditambahkan pada user.');
            }else{
                return redirect()
                    ->route('user.show', $user)
                    ->with('error', 'Role gagal ditambahkan pada user.');
            }
        }
    }

    /**
     * removed role from user
     * 
     * @param App\Models\User
     * @param App\Models\UserRoles
     * @return Illuminate\Http\Response
     */
    public function removeRole(User $user,UserRoles $userRole){
        if($userRole->delete()){
            return redirect()
                ->route('user.show', $user)
                ->with('success', 'Role berhasil dihapus dari user.');
        }else{
            return redirect()
                ->route('user.show', $user)
                ->with('error', 'Role gagal dihapus dari user.');
        }
    }

    /**
     * reset user password to default
     * 
     * @param \App\Models\User $user
     * @return Illuminate\Http\Response
     */
    public function resetPassword(User $user){
        $defaultPassword = "admin1234";
        $user->password = Hash::make($defaultPassword);

        if( $user->update() ){
            return redirect()
                ->route('user.index')
                ->with('success', 'Password berhasil di-reset.');
        }else{
            return redirect()
                ->route('user.index')
                ->with('error', 'Password gagal di-reset.');
        }

    }

    /**
     * display json data type of user
     * 
     */
    public function json(){
        $user = User::orderBy('created_at','DESC')
            ->select(['id','name','email'])
            ->get();

        $datatables = datatables()
            ->of($user)
            ->addColumn('roles',function($data){
                $roles = $this->userRole($data->id)
                    ->select('nama')
                    ->count();
                $final = $roles. " Role";

                return $final;
            })
            ->addColumn('action',function($data) {
                $routeDetail = route('user.show', $data);
                $routeUpdate = route('user.edit', $data);
                $routeDestroy = route('user.destroy', $data);
                $routeReset = route('user.reset-password', $data);

                $token = csrf_token();
                $csrf = "<input type='hidden' value='$token' name='_token'>";
                $methodDelete = "<input type='hidden' value='DELETE' name='_method'>";
                
                $buttonUpdate = "
                            <a href='$routeUpdate' class='btn btn-primary mb-1 mr-1'>
                                <i class='fa fa-pencil-alt'></i> Ubah
                            </a>";
                $buttonDetail = "
                            <a href='$routeDetail' class='btn btn-warning mb-1 mr-1'>
                                <i class='fa fa-eye'></i> Detail
                            </a>";
                $buttonDestroy = "
                            <form action='$routeDestroy' method='post' class='d-inline-block'> 
                                $csrf 
                                $methodDelete 
                                <button class='btn btn-danger mb-1 mr-1 deleteAlerts'>
                                    <i class='fa fa-trash'></i> Hapus
                                </button>
                            </form>";

                $buttonReset = "
                            <form action='$routeReset' method='post' class='d-inline-block'> 
                                $csrf 
                                <button class='btn btn-success mb-1 mr-1 deleteAlerts'>
                                    <i class='fa fa-user'></i> Reset Password
                                </button>
                            </form>";
                
                $html = "$buttonUpdate $buttonDetail $buttonDestroy $buttonReset";
                
                return $html;
            })
            ->make(true);

        return $datatables;
    }
}
