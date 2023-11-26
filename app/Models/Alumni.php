<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alumni extends Model
{
    use HasFactory;
    protected $table = 'alumni';
    protected $fillable = [
        'nama',
        'nomer',
        'alamat'
    ];
    public function DetailAccount(): BelongsTo
    {
        return $this->belongsTo(User::class, 'account', 'id');
    }
    public function Account(): BelongsTo
    {
        return $this->belongsTo(User::class, 'account', 'id');
    }

}
