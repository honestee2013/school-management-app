<?php 
namespace App\Models\Honestee\VueCodeGen;

use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;
use App\Models\Honestee\VueCodeGen\User;


class Classroom extends Model
{
    use UsesTenantConnection;

    public $timestamps = true;


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var  array
     */
    protected $guarded = [
        'id'
    ];


    protected $fillable = [
        'created_at',
        'updated_at',
        'section_id',
        'name'
    ]; 

    /**
     * The attributes that should be cast to native types.
     *
     * @var  array
     */
    protected $casts = [
        ''
    ];


    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

 
} ?>