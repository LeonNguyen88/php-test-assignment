<?php

namespace App\Services;

use App\Contracts\AirtableDrawingRepositoryContract;
use App\Contracts\AirtableModelModelRepositoryContract;
use App\Contracts\AirtableModelRepositoryContract;

class AirtableModelModelService {
    protected $airtableModelModelRepository;
    protected $airtableDrawingRepository;
    protected $airtableModelRepository;

    public function __construct(AirtableModelModelRepositoryContract $airtableModelModelRepositoryContract,
                                AirtableModelRepositoryContract $airtableModelRepositoryContract,
                                AirtableDrawingRepositoryContract $airtableDrawingRepositoryContract)
    {
        $this->airtableModelModelRepository = $airtableModelModelRepositoryContract;
        $this->airtableDrawingRepository = $airtableDrawingRepositoryContract;
        $this->airtableModelRepository = $airtableModelRepositoryContract;
    }

    public function store($modelModels) {

        foreach ($modelModels as $modelModel) {
            $record = $modelModel['fields'];
            $record['airtable_id'] = $modelModel['id'];
            $modelModelRow = $this->airtableModelModelRepository->firstOrNew(['airtable_id' => $modelModel['id']]);
            if (isset($record['parent_number'])) {
                $parentModel = $this->airtableModelRepository->firstOrNew(['airtable_id' => $record['parent_number'][0]]);
                $modelModelRow->parent()->associate($parentModel);
            }

            if (isset($record['dwg_no'])) {
                $drawing = $this->airtableDrawingRepository->firstOrNew(['airtable_id' => $record['dwg_no'][0]]);
                $modelModelRow->drawing()->associate($drawing);
            }
            if (isset($record['number'])) {
                $childModel = $this->airtableModelRepository->firstOrNew(['airtable_id' => $record['number']]);
                $modelModelRow->child()->associate($childModel);
            }

            if (!$modelModelRow->exists) {
                $this->airtableModelModelRepository->store($modelModelRow, $record);
            } else {
                $this->airtableModelModelRepository->update($modelModelRow, $record);
            }
        }
    }


}
