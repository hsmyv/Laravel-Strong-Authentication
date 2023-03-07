*******************Clean Code*******************

UserController: Register, Login and User Update adittionally


    public function register(RegisterRequest $request)
    {
        $fields = $request->validated();

        $user = User::create($fields);

        $token = $user->createToken('myappToken')->plainTextToken;

        $response = authResponse($user, $token);


        return response($response, 201);
    }

    public function login(LoginRequest $request)
    {

        $fields = $request->validated();

        if (Auth::guard('web')->attempt($fields)) {

            $user = Auth::user();

            $token = $user->createToken('myappToken')->plainTextToken;

            $response = authResponse($user, $token);

            return response($response, 201);
        } else {
            throw ValidationException::withMessages([
                'Error' => ['Invalid credentials'],
            ]);
        }
    }

    public function update(UpdateRequest $request)
    {
        $fields = $request->validated();
        $user = $request->user();

        $user->update($fields);

        return success(['message' => 'User details updated successfully.']);
    }

    public function index()
    {
        $users = User::orderBy('name', 'asc')->get();
        return $users;
    }
    
    
RegisterRequest:

         public function rules()
            {
                return [
                    'name' => 'required',
                    'email' => 'required|string|unique:users,email',
                    'password' => 'required|string'
                ];
            }
LoginRequest:

          public function rules()
            {
                return [
                    'email' => 'required|string|exists:users,email',
                    'password' => 'required|string'
                ];
            }

UpdateRequest:

            public function rules()
            {
                $user = Auth::user();
                return [
                    'name' => 'required',
                    'email' => ['required', Rule::unique('users')->ignore($user->id),],
                ];
            }
    
Helpers function:
    
    <?php

    use App\Models\User;

    function authResponse(User $user, $token)
    {
        return [
            'user' => $user,
            'token'=> $token
        ];
    }


    function success($data, $status = 200)
    {
        return response($data, $status);
    }

     function error($data, $status = 401)
    {
        return response($data, $status);
    }
    ?>
    
We have to avoid from use to fetch Users like *'User::all();'*

     public function index()
    {
        $users = User::orderBy('name', 'asc')->get();
        return $users;
    }
    
API.php. In this section we use 'rate limit' to limit login request for IP;
('throttle:1,1,ip')  ---->   1 request per 1 minute for IP
    
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::apiResource('users', UserController::class);
    });
    Route::post('register', [UserController::class, 'register']);
    Route::middleware('throttle:1,1,ip')->post('login', [UserController::class, 'login']);

