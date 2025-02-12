<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    //Show login form
    public function showLogin() {
        return view('user_views.login'); // CARGA LA VIEW DE LOGIN PARA PODER REALIZAR LOGIN
    }

    //Do login
    public function doLogin(Request $request) {
        // VALIDAR DATOS DE ENTRADA
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email:rfc,dns',
            'password' => 'required|string'
        ], [
            "email.required" => 'Por favor, ingrese el email',
            "password.required" => 'Por favor, ingrese la contraseña'
        ]);
        // SI LOS DATOS SON INVÁLIDOS, DEVOLVER A LA PÁGINA ANTERIOR E IMPRIMIR LOS ERRORES DE VALIDACIÓN

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        // SI LOS DATOS SON VÁLIDOS (SI EL LOGIN ES CORRECTO) CARGAR LA VISTA PRINCIPAL DEL USUARIO.
        $user = User::where("email", $request->get("email"))->first();

        

        // LA VISTA PRINCIPAL DE USUARIO DEBE INCLUIR:
        /*
            -> Un header que contenga el nombre del usuario.
            -> Un botón de logout que redirija a la view de login.

            -> La lista de tareas, tanto pendientes como realizadas, que el usuario tiene asignadas.
            -> Un botón al lado de cada tarea para eliminar la tarea.
            -> Un botón para marcar como hecha la tarea.
        */
        if ($user && password_verify($request->get("password"), $user->password)) {
            return view('user_views.index', compact("user")); // CARGA LA VIEW PRINCIPAL CON LA INFO DEL USUARIO
        } else {
            return redirect()->back()->withErrors($validator);
        }
    }

    //Show register form
    public function showRegister() {
        return view('user_views.register'); // CARGA LA VIEW DE REGISTER PARA PODER REALIZAR UN ALTA DE USUARIO
    }

    //Do register
    public function doRegister(Request $request) {

        // VALIDAR DATOS DE ENTRADA. LAS REGLAS DE VALIDACIÓN SON LAS SIGUIENTES:
        /*
            -> nombre es obligatorio, debe ser un string y debe ser menor de 20 carácteres
            -> email es obligatorio, debe seguir un formato estándar, debe ser único en la base de datos
            -> password es obligatoria, debe ser mayor de 5 carácteres, menor de 20 carácteres, debe contener una minúscula, una mayúscula y al menos un dígito
            -> password_repeat es obligatoria y debe ser igual a password
        */

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:20',
            'email' => 'required|string|email:rfc,dns|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:6',
                'max:20',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
            ],
            'repeat_password' => 'required|string|same:password'
        ], [
            "name.required" => 'Por favor, ingrese el nombre',
            "name.max" => 'El nombre no debe superar los 20 caracteres',
            "email.required" => 'Por favor, ingrese el email',
            "email.email" => 'El formato del email no es válido',
            "email.unique" => 'El email ya está en uso',
            "password.required" => 'Por favor, ingrese la contraseña',
            "password.min" => 'La contraseña debe tener al menos 6 caracteres',
            "password.max" => 'La contraseña no debe superar los 20 caracteres',
            "password.regex" => 'La contraseña debe contener al menos una mayúscula, una minúscula y un número',
            "repeat_password.required" => 'Por favor, ingrese el campo de repetir contraseña',
            "repeat_password.same" => 'Las contraseñas no coinciden'
        ]);

        
        // SI LOS DATOS SON INVÁLIDOS, DEVOLVER A LA PÁGINA ANTERIOR E IMPRIMIR LOS ERRORES DE VALIDACIÓN
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        // SI LOS DATOS SON VÁLIDOS (SI EL REGISTRO SE HA REALIZADO CORRECTAMENTE) CARGAR LA VIEW DE LOGIN PARA PODER REALIZAR LOGIN
        $user = new User();
        $user->name = $request->get("name");
        $user->email = $request->get("email");
        $user->password = Hash::make($request->get("password"));

        $user->save();

        return view('user_views.login'); // CARGA LA VIEW DE LOGIN PARA PODER REALIZAR LOGIN
    }
}
