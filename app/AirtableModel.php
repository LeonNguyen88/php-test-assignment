<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AirtableModel extends Model
{

    protected $fillable = [
        'number',
        'description',
        'unit',
        'interchangeable_with_id',
        'note',
        'airtable_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function interchangeableWiths(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AirtableModel::class, 'interchangeable_with_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function parents(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(AirtableModel::class, 'airtable_model_model', 'id', 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function children(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {

        return $this->belongsToMany(AirtableModel::class, 'airtable_model_model', 'id', 'child_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function services(): \Illuminate\Database\Eloquent\Relations\HasMany
    {

        return $this->hasMany(AirtableService::class, 'model_id', 'id');
    }
}
