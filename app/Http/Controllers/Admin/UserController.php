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
        $users = User::with('roles')
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
     * Store a newly created resource in storage.
     * 
     * @author Montserrat Vazquez Manrique | montsevm.03@gmail.com
     * @created 08/12/2021
     * @param StoreUserRequest $request User $user
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        //dd($request->all());
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
     * Function validate the specified resource in storage.
     * @author Montserrat Vazquez Manrique | montsevm.03@gmail.com
     * @created 13-12-2021
     * @param UpdateUserPut $request User $user
     * @return \Illuminate\Http\JsonResponse
     * 
     */
    public function userValidate(UpdateUserRequest $request, $id)
    {
        return response()->json([
            'statusCode'=>200,
            'message' =>'Datos validados correctamente'
        ]);  

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
            'statusCode'=> 200,
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
