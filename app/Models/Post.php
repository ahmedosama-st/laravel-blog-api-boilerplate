<?php

namespace App\Models;

use App\Traits\Orderable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory, Orderable;

    protected $fillable = ['body'];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
