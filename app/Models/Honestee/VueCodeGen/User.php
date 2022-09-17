<?php 
namespace App\Models\Honestee\VueCodeGen;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
//use App\Models\Role;
//use Laratrust\Traits\LaratrustUserTrait;

use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

use App\Models\Honestee\VueCodeGen\Classroom;


use Spatie\Permission\Traits\HasRoles;



class User extends Authenticatable // implements MustVerifyEmail
{
    use UsesTenantConnection;

    use HasRoles;

    //use LaratrustUserTrait;
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'user_number',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

     /**
     * Get the profile photo URL attribute.
     *
     * @return string
     */
    public function getPhotoAttribute()
    {
        return 'https://www.gravatar.com/avatar/' . md5(strtolower($this->email)) . '.jpg?s=200&d=mm';
    }


    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class);
    }



   
}
