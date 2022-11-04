<?php 
namespace App\Models\Honestee\VueCodeGen;

use Illuminate\Database\Eloquent\Model;
use App\Models\Honestee\VueCodeGen\Classroom;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;


class Subject extends Model
{
    use UsesTenantConnection;


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var  array
     */
    protected $guarded = [
        'id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var  array
     */
    protected $casts = [
        ''
    ];

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class)->withTimestamps();
    }


    

 
} ?>