<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AirtableDrawing extends Model
{

    protected $fillable = [
        'name',
        'airtable_id',
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function model(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AirtableModelModel::class, 'dwg_id', 'id');
    }
}
