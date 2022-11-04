<?php 
namespace App\Models\Honestee\VueCodeGen;

use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;
use App\Models\Honestee\VueCodeGen\Subject;
use App\Models\Honestee\VueCodeGen\User;
use App\Models\Honestee\VueCodeGen\Section;



class Classroom extends Model
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


    public function subjects()
    {
        return $this->belongsToMany(Subject::class)->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

 
} ?>