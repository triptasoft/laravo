<?php

namespace Triptasoft\Laravo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Chart extends Model
{
    
    public function scopeOwner($query)
    {
        return Auth::user()->hasRole('admin') ? $query : $query->where('user_id', Auth::user()->id);
    }

    // public function save(array $options = [])
    // {
    //     // If no owner has been assigned, assign the current user's id as the owner of the workstation
    //     if (!$this->user_id && Auth::user()) {
    //         $this->user_id = Auth::user()->getKey();
    //     }

    //     return parent::save();
    // }
}
