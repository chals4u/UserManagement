<?php

    namespace App\Http\Controllers;

    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use JWTAuth;
    use Tymon\JWTAuth\Exceptions\JWTException;

    class UserController extends Controller
    {
        public function authenticate(Request $request)
        {
            $credentials = $request->only('username', 'password');

            try {
                if (! $token = JWTAuth::attempt($credentials)) {
                    return response()->json(['error' => 'invalid_credentials'], 400);
                }
            } catch (JWTException $e) {
                return response()->json(['error' => 'could_not_create_token'], 500);
            }
            return response()->json(compact('token'));
        //     return response()->json(['statusCode'=>'200','message' => 'Login Successful'], 200);
        }

        public function register(Request $request)
        {
                $validator = Validator::make($request->all(), [
                'username' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);

            if($validator->fails()){
                    return response()->json($validator->errors(), 400);
            }

            $user = User::create([
                'username' => $request->get('username'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
                "phone"    =>$request->get('phone'),
            ]);

            $token = JWTAuth::fromUser($user);

            return response()->json(compact('user','token'),201);
        }

        public function getAll(Request $request )
            {
                try {
                       
                        $userType= $request->get('type');
                        if($userType=="admin"){
                        if (! $user = JWTAuth::parseToken()->authenticate()) {
                                return response()->json(['user_not_found'], 404);
                        }
                        $user=User::where('username', '!=', 'admin')->get();
                        }
                        else{
                        return response()->json(['statusCode'=>'404','message' => 'Access Denied'], 404);
                        }
                    } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

                            return response()->json(['token_expired'], $e->getStatusCode());

                    } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

                            return response()->json(['token_invalid'], $e->getStatusCode());

                    } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

                            return response()->json(['token_absent'], $e->getStatusCode());

                    }

                    return response()->json(compact('user'));
            }
            public function approve(Request $request )
            {
                try {
                        $userType= $request->get('type');
                        $id=array();
                        $userid= $request->get('userid');
                        foreach ($userid as $value) {
                                array_push($id,$value);
                              }
                            
                        if($userType=="admin"){
                        if (! $user = JWTAuth::parseToken()->authenticate()) {
                                return response()->json(['user_not_found'], 404);
                        }
                        $user=User::whereIn('id', $id)->update(array('status' => 'Active'));
                        return response()->json(['statusCode'=>'200','message' => 'Users has been Activated'], 404);
                        }
                        else{
                        return response()->json(['statusCode'=>'404','message' => 'Access Denied'], 404);
                        }
                    } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

                            return response()->json(['token_expired'], $e->getStatusCode());

                    } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

                            return response()->json(['token_invalid'], $e->getStatusCode());

                    } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

                            return response()->json(['token_absent'], $e->getStatusCode());

                    }

                  
            }
            public function update(Request $request )
            {
                try {
                        $validator = Validator::make($request->all(), [
                                'username' => 'required|string|max:255',
                                'email' => 'required|string|email|max:255|unique:users',
                                'password' => 'required|string|min:6|confirmed',
                            ]);
                
                            if($validator->fails()){
                                    return response()->json($validator->errors(), 400);
                            }
                
                        $userType= $request->get('type');
                        $username=$request->get('username');
                        $email=$request->get('email');
                        $password= Hash::make($request->get('password'));
                        $phone=$request->get('phone');
                        $status='Active';
                        $id=array();
                        $userid= $request->get('userid');
                        foreach ($userid as $value) {
                                array_push($id,$value);
                              }
                            
                      
                        if (! $user = JWTAuth::parseToken()->authenticate()) {
                                return response()->json(['user_not_found'], 404);
                        }
                        $user=User::whereIn('id', $id)->update(array('username'=>$username,'email'=>$email,'password'=>$password,'phone'=>$phone,'status'=>$status));
                        return response()->json(['statusCode'=>'200','message' => 'Users has been Editted'], 404);
                       
                    } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

                            return response()->json(['token_expired'], $e->getStatusCode());

                    } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

                            return response()->json(['token_invalid'], $e->getStatusCode());

                    } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

                            return response()->json(['token_absent'], $e->getStatusCode());

                    }

                  
            }
            public function edit(Request $request )
            {
                try {
                        $validator = Validator::make($request->all(), [
                                'username' => 'required|string|max:255',
                                'email' => 'required|string|email|max:255|unique:users',
                                'password' => 'required|string|min:6|confirmed',
                            ]);
                
                            if($validator->fails()){
                                    return response()->json($validator->errors(), 400);
                            }
                
                        $userType= $request->get('type');
                        $username=$request->get('username');
                        $email=$request->get('email');
                        $password= Hash::make($request->get('password'));
                        $phone=$request->get('phone');
                        $status='Active';
                        $id=array();
                        $userid= $request->get('userid');
                        foreach ($userid as $value) {
                                array_push($id,$value);
                              }
                            
                        if($userType=="admin"){
                        if (! $user = JWTAuth::parseToken()->authenticate()) {
                                return response()->json(['user_not_found'], 404);
                        }
                        $user=User::whereIn('id', $id)->update(array('username'=>$username,'email'=>$email,'password'=>$password,'phone'=>$phone,'status'=>$status));
                        return response()->json(['statusCode'=>'200','message' => 'Users has been Editted'], 404);
                        }
                        else{
                        return response()->json(['statusCode'=>'404','message' => 'Access Denied'], 404);
                        }
                    } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

                            return response()->json(['token_expired'], $e->getStatusCode());

                    } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

                            return response()->json(['token_invalid'], $e->getStatusCode());

                    } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

                            return response()->json(['token_absent'], $e->getStatusCode());

                    }

                  
            }
            public function delete(Request $request)
            {
                try {
                        $userType= $request->get('type');
                        $id=array();
                        $userid= $request->get('userid');
                        foreach ($userid as $value) {
                                array_push($id,$value);
                              }
                            
                        if($userType=="admin"){
                        if (! $user = JWTAuth::parseToken()->authenticate()) {
                                return response()->json(['user_not_found'], 404);
                        }
                        $user=User::whereIn('id', $id)->delete();
                        
                        return response()->json(['statusCode'=>'200','message' => 'Users has been Deleted'], 404);
                        }
                        else{
                        return response()->json(['statusCode'=>'404','message' => 'Access Denied'], 404);
                        }
                    } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

                            return response()->json(['token_expired'], $e->getStatusCode());

                    } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

                            return response()->json(['token_invalid'], $e->getStatusCode());

                    } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

                            return response()->json(['token_absent'], $e->getStatusCode());

                    }

                  
            }

            

    }