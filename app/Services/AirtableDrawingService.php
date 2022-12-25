<?php

namespace App\Services;

use App\Contracts\AirtableDrawingRepositoryContract;

class AirtableDrawingService {
    protected $airtableDrawingRepository;

    public function __construct(AirtableDrawingRepositoryContract $airtableDrawingRepositoryContract)
    {
        $this->airtableDrawingRepository = $airtableDrawingRepositoryContract;
    }

    public function store($drawings) {

        foreach ($drawings as $drawing) {
            $record = $drawing['fields'];
            $record['airtable_id'] = $drawing['id'];

            $drawingRow = $this->airtableDrawingRepository->firstOrNew(['airtable_id' => $drawing['id']]);

            if (!$drawingRow->exists) {
                $this->airtableDrawingRepository->store($drawingRow, $record);
            } else {
                $this->airtableDrawingRepository->update($drawingRow, $record);
            }

        }
    }
}
