<?php
declare(strict_types=1);
namespace App\Models;
use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
class Region extends Model implements Auditable
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
            'region_name',
        ];
        public function districts()
        {
            return $this->hasMany(District::class, 'region_id', 'id');
        }

        /**
        * The attributes that should be cast.
        *
        * @var array<string, string>
        */
        protected $casts = [

        ];
}
