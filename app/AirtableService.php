<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AirtableService extends Model
{

    protected $fillable = [
        'name',
        'instructions',
        'condition',
        'recurring',
        'airtable_id',
        'calendar_interval',
        'calendar_interval_unit',
        'running_hours_interval',
        'alternative_interval',
        'alternative_interval_description',
    ];

    protected $guarded = ['model_id', 'service_group_id'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function model(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(AirtableModel::class, 'model_id', 'id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function serviceGroup(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(AirtableService::class, 'service_group_id', 'id');
    }
}
