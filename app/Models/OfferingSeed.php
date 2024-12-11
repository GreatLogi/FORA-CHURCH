<?php
declare (strict_types = 1);
namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OfferingSeed extends Model implements Auditable
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
        'remarks',
        'user_id',
        'amount',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public static function updateAccountBalance($amount)
    {
        $account = Account::first();

        // Ensure the account exists; create it if not
        if (!$account) {
            $account = Account::create(['balance' => '0.00']); // Initialize with string '0.00'
        }

        // Convert balance and amount to strings for bcadd
        $account->balance = bcadd((string) $account->balance, (string) $amount, 2);
        $account->save();
    }

    public static function decrementAccountBalance($amount)
    {
        $account = Account::first();

        // Ensure the account exists; create it if not
        if (!$account) {
            $account = Account::create(['balance' => '0.00']); // Initialize with string '0.00'
        }

        // Convert balance and amount to strings for bcsub
        $account->balance = bcsub((string) $account->balance, (string) $amount, 2);
        $account->save();
    }

    protected $casts = [

    ];
}
