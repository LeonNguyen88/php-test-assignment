<?php

namespace App\Services;

use App\Contracts\AirtableModelRepositoryContract;

class AirtableModelService {
    protected $airtableModelRepository;

    public function __construct(AirtableModelRepositoryContract $airtableModelRepositoryContract)
    {
        $this->airtableModelRepository = $airtableModelRepositoryContract;
    }

    public function store($models) {


        foreach ($models as $model) {
            $modelRow = null;
            $record = $model['fields'];
            $record['airtable_id'] = $model['id'];

            $modelRow = $this->airtableModelRepository->firstOrNew(['airtable_id' => $model['id']]);


//            if (!$modelRow->id) {
//                dd('test');
                $this->airtableModelRepository->store($modelRow, $record);
//            } else {
//                $this->airtableModelRepository->update($modelRow, $record);
//            }
        }
    }
}
