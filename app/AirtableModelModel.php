<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AirtableModelModel extends Model
{

    protected $fillable = [
        'quantity',
        'dwg_ref_no',
        'airtable_id',
    ];

    protected $guarded = ['parent_id', 'dwg_id', 'child_id'];
    protected $table = 'airtable_model_model';
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function child(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {

        return $this->belongsTo(AirtableModel::class, 'child_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {

        return $this->belongsTo(AirtableModel::class, 'parent_id', 'id');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function drawing(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(AirtableDrawing::class, 'dwg_id', 'id');
    }
}
