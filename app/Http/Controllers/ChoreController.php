<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chore;

class ChoreController extends Controller
{
    //
    public function doMarkChoreAsDone($chore) {
        //param id
        $chore = Chore::find($chore);
        $chore->status = "completed";
        $chore->save();

        $user = $chore->user;
        return view('user_views.index', compact("user")); // CARGA LA VIEW PRINCIPAL CON LA INFO DEL USUARIO
    }

    public function doDeleteChore($chore) {
        $chore = Chore::find($chore);
        $user = $chore->user;
        $chore->delete();
        return view('user_views.index', compact("user")); // CARGA LA VIEW PRINCIPAL CON LA INFO DEL USUARIO
    }
}
