<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rol;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RolController extends Controller
{   
    /**
     * Function to Display a listing of the resource.
     * @author Montserrat Vazquez Manrique | montsevm.03@gmail.com
     * @created 12-03-2021
     * @param 
     * @return \Illuminate\Http\Response
     */
    public function listRoles()
    {
        return Rol::get();
    }
}
