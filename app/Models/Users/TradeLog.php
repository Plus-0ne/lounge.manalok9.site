<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeLog extends Model
{
    use HasFactory;

    protected $table='trade_logs';


    protected $fillable = [
        'trade_log_no',
        'trade_no',

        'iagd_number',
        'animal_no',
        'cash_amount',

        'role',
        'accepted',
        'expiration',
        'log_status',
    ];

    public function Trade()
    {
        return $this->hasOne(Trade::class,'trade_log_no','trade_log_no');
    }
    public function MembersModel()
    {
        return $this->hasOne(MembersModel::class,'iagd_number','iagd_number');
    }
}
