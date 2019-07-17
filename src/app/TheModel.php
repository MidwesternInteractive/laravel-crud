<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Traits\TheModelHelpers;
use App\Traits\TheModelManagement;

class TheModel extends Model
{
    use SoftDeletes,
        TheModelHelpers,
        TheModelManagement;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'column_one'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['column_one'];

    /**
     * Fields that should be treated as dates
     * 
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Scopes
     *
     */


    /**
     * Relationships
     *
     */


    /**
     * Accessors
     *
     */


    /**
     * Mutators
     *
     */

}
