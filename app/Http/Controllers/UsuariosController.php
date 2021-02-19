<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users = User::all();
        // if (Cache::has('users.all')) {
        //     $filter = Cache::get('users.all');
        // }else{
        //     $filter = $users->where('estatus',1)
        //                 ->all();
        //     Cache::put('users.all',$filter,7200);
        // }
        $filter = $users->where('estatus',1)
                         ->all();
        return view('usuarios.index',compact('filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles =Role::all()->pluck('name','id');
        return view('usuarios.create',compact('roles'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request->all();
        $estatus = 1;    
        $usuario = new User;
        $usuario->name =strtoupper($request->name);
        $usuario->email = $request->email;
        $usuario->password = bcrypt($request->password);
        $usuario->estatus = $estatus;

        if($usuario->save()){
            //asignar rol
            $usuario->assignRole($request->rol);
            return redirect()->route('usuarios.index')->with('status', 'Usuario Registrado Correctamente');
        }
        Cache::flush();
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
        $usuario = User::findOrFail($id);
        $roles =Role::all()->pluck('name','id');

        return view('usuarios.edit',compact('usuario','roles'));
        Cache::flush();
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
        $usuario = User::findOrFail($id);

       if($request->input('password')!=null){
           DB::table('tbbakanCod_genericousers')
                ->where('id', $id)
                ->update([
                    'name' => strtoupper($request->input('name')),
                    'email' => $request->input('email'),
                    'password' => Hash::make($request->input('password')),
                ]);
        }else{
            DB::table('tbbakanCod_genericousers')
            ->where('id', $id)
            ->update([
                'name' => strtoupper($request->input('name')),
                'email' => $request->input('email'),
                ]);
        }
        $usuario->syncRoles($request->rol);
        return redirect()->route('usuarios.index')->with('status', 'Usuario Editado Correctamente ');
        Cache::flush();
    }

    public function baja($id)
    {
        $estatus = 0;  
        DB::table('tbbakanCod_genericousers')
            ->where('id',$id)
            ->update([
                'estatus' => $estatus,
            ]);

        return redirect()->route('usuarios.index')->with('status', 'Usuario Eliminado Correctamente');
        Cache::flush();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
