<?php

namespace App\Models;

// use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Profile extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function profileImage()
    {
        $imagePath = ($this->image) ?  $this->image : 'profile/utzVYL2Rl9Nj6Idq3OlbWjCK4IqCquXfz2AurxyP.webp';
        return '/storage/' . $imagePath;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class);
    }

    // protected $connection = 'mongodb';
}
