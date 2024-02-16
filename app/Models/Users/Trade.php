<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    use HasFactory;

    protected $table='trades';


    protected $fillable = [
        'trade_no',
        'trade_log_no',
        'description',

        'poster_iagd_number',
        'poster_animal_no',
        'poster_cash_amount',

        'requester_iagd_number',
        'requester_animal_no',
        'requester_cash_amount',
        
        'trade_status',

        'created_at',
        'updated_at',
    ];
    public function TradeLog()
    {
        return $this->hasMany(TradeLog::class,'trade_log_no','trade_log_no');
    }
}
