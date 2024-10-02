<?php

namespace App\Models\Blog;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'content', 'excerpt', 'user_id'];

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
