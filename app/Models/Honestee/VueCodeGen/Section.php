<?php 
namespace App\Models\Honestee\VueCodeGen;

use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;
use App\Models\Honestee\VueCodeGen\Classroom;


class Section extends Model
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
        return $this->hasMany(Classroom::class);
    }




 
} ?>