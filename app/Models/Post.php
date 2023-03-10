<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'body'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function title(): Attribute
    {
        return new Attribute(
            function ($value) {
                return decrypt($value);
            },
            function ($value) {
                return encrypt($value);
            }
        );
    }
}
