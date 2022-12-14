<?php 
namespace App\Models\Honestee\VueCodeGen;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
//use App\Models\Role;
//use Laratrust\Traits\LaratrustUserTrait;
use App\Models\Honestee\VueCodeGen\Classroom;


use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use URL;


class User extends Authenticatable implements HasMedia // implements MustVerifyEmail
{
    use UsesTenantConnection;

    use HasRoles;
    use InteractsWithMedia;


    //use LaratrustUserTrait;
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'gender', 'phone', 'password', 'user_number',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['profile_picture'];

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
        return $this->belongsToMany(Classroom::class)->withTimestamps();
    }

    public function currentClassroom()
    {
        return $this->belongsToMany(Classroom::class)->orderBy('id', 'desc')->take(1);
    }

    

    public function getProfilePictureAttribute(){

        $userImages = $this->getMedia("user-images");
        for($i=0; $i < count($userImages); $i++){
            if($userImages[$i]->name == "profilePicture"){
                $url = $userImages[$i]->getUrl();
                $url = str_replace("localhost", "localhost:8000", $url);
                return $url;
            } 
        }

        return URL::asset('/images/'. strtolower($this->gender).'ProfilePicture.png'); // Default file url

    }

    //$model->getFirstMediaUrl('image', 'resized') ?? asset('path/to/img');

    

    /*public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Assigning User role
     *
     * @param \App\Models\Role $role
     * /
    public function assignRole(Role $role)
    {
        return $this->roles()->save($role);
    }

    public function isAdmin()
    {
        return $this->roles()->where('name', 'Admin')->exists();
    }

    public function isUser()
    {
        return $this->roles()->where('name', 'User')->exists();
    }*/
}
