<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 't_transaction';
    protected $primaryKey = 'transaction_id';
    protected $fillable = [
        'transaction_id',
        'user_id',
        'transaction_code',
        'type',
        'amount',
        'description',
        'transfer_receipt'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }
}
