<?php
declare (strict_types = 1);
namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Membership extends Model implements Auditable
{
    use HasFactory;
    use UuidTrait;
    use \OwenIt\Auditing\Auditable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'lastname',
        'othernames',
        'first_name',
        'dob',
        'gender',
        'marital_status',
        'tribe',
        'hometown_district',
        'hometown_region',
        'educational_background',
        'occupation',
        'blood_group',
        'sickcell_type',
        'status',
        'title',
        'email',
        'phone',
        'secondary_phone',
        'residential_address',
        'member_image',
    ];
    public function tribes()
    {
        return $this->belongsTo(Tribe::class, 'tribe', 'id');
    }
    public function home_districts()
    {
        return $this->belongsTo(District::class, 'hometown_district', 'id');
    }
    public function hometown_regions()
    {
        return $this->belongsTo(Region::class, 'hometown_region', 'id');
    }
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [

    ];
}
