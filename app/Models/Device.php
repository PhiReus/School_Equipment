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
    protected $fillable = ['id','device_type_id','name', 'quantity','image'];

    public function borrows()
    {
        return $this->belongsToMany(Borrow::class,'borrow_devices','device_id','borrow_id');
    }
    public function devicetype()
    {
        return $this->belongsTo(DeviceType::class,'device_type_id','id');
    }
}
