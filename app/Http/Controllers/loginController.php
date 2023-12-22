<?php

namespace App\Http\Controllers;



use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;
use function Laravel\Prompts\error;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;


class loginController extends Controller
{

  public function login(Request $request)
  {
    $request->validate([
      'email' => 'required | email ',
      'password' => 'required |max:20 |min:6'
    ]);

    $user = User::where('email', '=', $request->email)->first();
    if ($user) {
      if (Hash::check($request->password, $user->password)) {
        // $request->session()->put('loginId',$request->id);
        // Assuming your User model has an 'id' column
        $request->session()->put('loginId', $user->id);
        // return response()->json([
        //   'redirect' => route('dashboard', ['loginId' => $request->session()->get('loginId')]),
        //   'loginId' => $request->session()->get('loginId')
        // ]);


        return response()->json([
          'redirect' => route('dashboard', ['loginId' => $request->session()->get('loginId')]),
          'loginId' => $request->session()->get('loginId')
        ]);
        

        return redirect()->route('dashboard');






      } else {
        return Response::json(['errorPassword' => 'Password is not matching']);
      }
    } else {
      return Response::json(['errorEmail' => 'Email is not valid !']);
    }
  }

  public function register(Request $request)
  {

    $request->validate([
      'username' => 'required | max:50 | min:2',
      'email' => 'required | email |unique:users',
      'password' => 'required |max:20 |min:6'
    ]);

    if (!empty($request->username && $request->password && $request->email)) {
      User::create([
        'username' => $request->username,
        'password' => Hash::make($request->password),
        'email'    => $request->email
      ]);

      // Return a success message as JSON
      return Response::json(['success' => 'Registered Successfully']);
    }

    return response()->json();
  }




  public function dashboard(Request $request)
  {

    $loginId = $request->session()->get('loginId');

    if (!empty($loginId)){

      $userData = User::where('id','=',$loginId)->select('id','username')->first();

      return view('dashboard.dashboard',compact('userData'));
    }
    return redirect()->route('loginPage');


    // return view('dashboard');

  }


public function logout(){
  if(Session::has('loginId')){
    Session::pull('loginId');
    
    return redirect('/');
  }
 
}


public function loginPage(){
  return view('auth.login');
}
}
