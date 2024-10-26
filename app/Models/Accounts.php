<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Accounts extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'balance',
    ];

    public function events(): HasMany
    {
        return $this->hasMany(Events::class);
    }

}
