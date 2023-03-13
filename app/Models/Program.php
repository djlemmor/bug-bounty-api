<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'pentesting_start_date',
        'pentesting_end_date',
    ];

    protected $casts = [
        'pentesting_start_date' => 'datetime',
        'pentesting_end_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
