<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;


class UserController extends Controller
{
    use HasRoles;
    /**
    * Function make a contruct
    
    * @author Montserrat Vazquez Manrique | montsevm.03@gmail.com
    * @created 08/12/2021
    * @param 
    * @return void
    */

    public function __construct()
    {
        $this->middleware('role:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.index');
    }

    /**
     * Function to Display a listing of the resource.
     * 
     * @author Montserrat Vazquez Manrique | montsevm.03@gmail.com
     * @created 08/12/2021
     * @param 
     * @return \Illuminate\Http\Response
     */
    public function listUsers(Request $request)
    {
        $users = User::select([
            'users.id as user_id',
            'users.name as user_name',
            'users.email as user_email',
            'users.position as user_position',
            'users.phone as user_phone',
            'users.extension as user_extension',
            'users.enrollment as user_enrollment',
            'users.created_at as user_created_at',
        ])
        ->with('roles')
        ->latest()
        ->paginate(8);

        return [
            'pagination' =>  [
                'total'         =>  $users->total(),
                'current_page'  =>  $users->currentPage(),
                'per_page'      =>  $users->perPage(),
                'last_page'     =>  $users->lastPage(),
                'from'          =>  $users->firstItem(),
                'to'            =>  $users->lastPage(),
            ],
            'users' => $users
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @author Montserrat Vazquez Manrique | montsevm.03@gmail.com
     * @created 08/12/2021
     * @param StoreUserRequest $request User $user
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->position = $request->position;
        $user->phone = $request->phone;
        $user->extension = $request->extension;
        $user->enrollment = $request->enrollment;
        $user->password = Hash::make('Hola1234*');
        $user->save();
        $user->roles()->sync($request->user_rol);

        return response()->json([
            'statusCode'=>200,
            'message' =>'Datos agregados correctamente',
        ]); 
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
        //
    }

    /**
     * Update the specified resource in storage.
     * 
     * @author Montserrat Vazquez Manrique | montsevm.03@gmail.com
     * @created 08/12/2021
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->position = $request->position;
        $user->phone = $request->phone;
        $user->extension = $request->extension;
        $user->enrollment = $request->enrollment;
        $user->save();
        $user->roles()->sync($request->user_rol);

        return response()->json([
            'statusCode'=>200,
            'message' =>'Datos actualizados correctamente',
        ]); 
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @author Montserrat Vazquez Manrique | montsevm.03@gmail.com
     * @created 08/12/2021
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'statusCode'=>200,
            'message' =>'Datos eliminados correctamente',
        ]); 
    }
}
