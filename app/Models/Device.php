<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
    use HasFactory;
    protected $table ='devices';
    use HasFactory,SoftDeletes;
    protected $fillable = ['id', 'name', 'quantity','image'];
    

}
