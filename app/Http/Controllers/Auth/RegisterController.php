<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
//use App\Models\Role;
//use App\Models\User;
use App\Models\Honestee\VueCodeGen\User;
//use App\Models\Honestee\VueCodeGen\Role;
use App\Models\Honestee\VueCodeGen\Code;
use App\Models\Honestee\VueCodeGen\Option;

use Spatie\Permission\Models\Role;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Artisan;
use Request;
use DB;
use URL;
use Redirect;
//use Illuminate\Support\Facades\Route;


use Spatie\Multitenancy\Models\Tenant;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $fields = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];

        if($data['role'] = "school-owner")
            $fields['website'] = 'unique:Spatie\Multitenancy\Models\Tenant,database';

        return Validator::make($data, $fields);
    }

    

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $code = null;
        $roleName = $data['role'];
        if($roleName == 'school-owner')
            $this->createTenantInfo($data['website']);
        else{
            $code = Code::where("value", $data['pincode'])->first();
            $this->exitForInvalidCode($code);
            $roleName = $code->user_type;
        }

        $generalRoleName = "staff";
        if( strpos($roleName, "student") > -1 || strpos($roleName, "prefect") > -1 || strpos($roleName, "class-head") > -1)
            $generalRoleName = "student";
        else if( strpos($roleName, "parent") )
            $generalRoleName = "parent";
       
        // Generate user unique number
        $userNumber = $this->createUserNumber($generalRoleName);

        // Create a new user
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'user_number' => $userNumber,
        ];
        $user = User::create($userData);

        // Assigning Role by default user role
        //$role = Role::where('name', $roleName)->first();
        //$generalRole = Role::where('name', $generalRoleName)->first();
        //$user->assignRole($role);
        //$user->assignRole($generalRole); 

        $user->syncRoles([$roleName, $generalRoleName]);

        // Update the code information
        if($roleName != 'school-owner'){
            $code->status = "used";
            $code->number_of_use = $code->number_of_use + 1;
            $code->used_by = $userNumber;
            $code->save();
        }


        //$userNumber = $this->createUserNumber('STA'); // For staff
        //$user->update(['user_number', $userNumber]);

        //redirect()->away("google.com");

       // exit(
           // "<a href='".Tenant::current()->domain.":8000'> www.".Tenant::current()->domain." </a>"
       // );
        
       //$this->redirectTo = "http://" .Tenant::current()->domain.":8000'";
        //generates a url for domain.app.url/login
       // URL::route('employee.login');

        //redirects to domain.app.url/login
        //return Redirect::route("http://" .Tenant::current()->domain.":8000");

        //Redirect::route('registration-finished', ['domain' => Tenant::current()->domain]);
        if($data['role'] == 'school-owner'){
            exit('
                <div class="alert alert-danger col-12 col-md-10 mx-md-5 my-md-5" role="alert">
                    <h2 class="alert-heading">Congratulations!</h2> <hr />
                    <ul style="font-size:1.2em">
                    <li> <div style="font-size:1.2em">To visit your website, type www.'.Tenant::current()->domain.' in the browser address bar. </div></li>
                    <li> <div style="font-size:1.2em"> To logon, type www.'.Tenant::current()->domain.'/login in the browser address bar. 
                        Then, enter the Email: '.$data['email'].'  and the Password that you used in this registration.</div></li>
                    </ul>
                    <br />
                </div>
            ');
        }

        // Assigning Role by default user role

        // $role = Role::where('name', 'User')->first();
        // $user->assignRole($role);

        return $user;
    }


    protected function exitForInvalidCode($code){

        if(!$code)
            exit("<h4>Invalid code!</h4>");

        $expiryDate = new \DateTime($code->expiry_date);
        
        if($code->use_for != "User registration")
            exit("<h4>This code is for ".$code->use_for.", not for registration!</h4>");
        else if(now() > $expiryDate )
            exit("<h4>This code has reached its expiring date: ".$expiryDate->format('Y-m-d H:i:s')."</h4>");
        else if( $code->number_of_use >= $code->maximum_use)
            exit("<h4>This code has reached its maximum use of ".$code->maximum_use." times!</h4>");
        else if( $code->used_by !=null)
            exit("<h4>This code was used by ".$code->used_by."</h4>");
    }



    protected function createTenantInfo($dbName){

        $domain =  $dbName.".".Request::getHost();

        $tenant_id = Tenant::insert([
            'name' => $dbName,
            'domain' => $domain,
            'database' => $dbName,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Get the default connection name, and the database name for that connection from laravel config.
        $connectionName = config('database.default');
        $databaseName = config("database.connections.{$connectionName}.database");
        // Set the database name to null so DB commands connect to raw mysql, not a database.
        config(["database.connections.{$connectionName}.database" => null]);

        // Create the db if it doesn't exist.
        DB::statement("CREATE DATABASE IF NOT EXISTS " . $dbName);

        // Reset database name and purge database-less connection from cache.
        config(["database.connections.{$connectionName}.database" => $dbName ]);
        DB::purge();

        // Migrate
        Artisan::call("tenants:artisan 'migrate --seed' --tenant={$tenant_id}");
        
        //dd(Artisan::output());
        Tenant::latest()->first()->makeCurrent();

    }


    protected function createUserNumber($role) {
        $prefix = "STA";

        if($role == "parent")
            $prefix = "PAR";
        else if($role == "parent")
            $prefix = "STU";

        $lastUserNumber = Option::where('key', $prefix.'LastUserNumber')->first();
        if($lastUserNumber)
            $lastUserNumber = intval($lastUserNumber->value);

        $lastUserNumberYear = Option::where('key', $prefix.'LastUserNumberYear')->first();
        if($lastUserNumberYear)
            $lastUserNumberYear = intval($lastUserNumberYear->value);

        if(!$lastUserNumberYear)
            $lastUserNumberYear = intval(date('y'));
        if($lastUserNumberYear < intval(date('y'))) // New year. Reset lastUserNumber
            $lastUserNumber = 0;

        $lastUserNumber = $lastUserNumber + 1 ; // Increase for new user number

        $userNumber = $prefix.dechex(Tenant::current()->id)."-".str_pad($lastUserNumber, 3, '0', STR_PAD_LEFT);
        //dd(User::where("user_number", $userNumber)->first());

        if(User::where("user_number", $userNumber)->first()){
            $lastUserNumber = $lastUserNumber + 1;
            $userNumber = $prefix.dechex(Tenant::current()->id)."-".str_pad($lastUserNumber, 3, '0', STR_PAD_LEFT);
        }

        option([$prefix.'LastUserNumber' => intval($lastUserNumber)]);
        option([$prefix.'LastUserNumberYear' => intval(date('y'))]);

        return $userNumber;
    
    }


    private function option($key, $value = null){
        $opt = Option::where('key', $key)->first();
        if($opt && !$value)
            return $opt->value;
        else if($opt && $value){
            $opt->where("id", $opt->id)->update(["value" =>$value]);
            return $value;
        }else if(!$opt && $value){
            Option::insert(['key' => $key, 'value' => $value]);
            return $value;
        }
    }

    




}
