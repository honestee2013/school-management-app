<?php 
namespace App\Models\Honestee\VueCodeGen;

use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class School extends Model implements HasMedia
{
    use UsesTenantConnection;
    use InteractsWithMedia;


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

 
} ?>