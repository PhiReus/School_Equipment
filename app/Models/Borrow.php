<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Borrow extends Model
{
    use HasFactory;
    protected $table ='borrows';
    use HasFactory,SoftDeletes;
    protected $fillable = ['id', 'user_id', 'borrow_date','created_at','updated_at','deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function devices()
    {
        return $this->hasMany(Device::class);
    }
}
