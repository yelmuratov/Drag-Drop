<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    protected $fillable = ['user_id', 'status'];
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
