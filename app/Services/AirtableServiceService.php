<?php

namespace App\Services;

use App\Contracts\AirtableModelRepositoryContract;
use App\Contracts\AirtableServiceRepositoryContract;
class AirtableServiceService {
    protected $airtableServiceRepository;

    protected $airtableModelRepository;

    public function __construct(AirtableServiceRepositoryContract $airtableServiceRepositoryContract,

                                AirtableModelRepositoryContract $airtableModelRepositoryContract)
    {
        $this->airtableServiceRepository = $airtableServiceRepositoryContract;
        $this->airtableModelRepository = $airtableModelRepositoryContract;
    }

    public function store($services) {

        foreach ($services as $service) {
            $record = $service['fields'];
            $record['airtable_id'] = $service['id'];

            $serviceRow = $this->airtableServiceRepository->firstOrNew(['airtable_id' => $service['id']]);
            if (isset($record['model'])) {
                $model = $this->airtableModelRepository->firstOrNew(['airtable_id' => $record['model'][0]]);
                $serviceRow->model()->associate($model);
            }
            if (isset($record['service_group'])) {
                $serviceGroup = $this->airtableServiceRepository->firstOrNew(['airtable_id' => $record['service_group']]);
                $serviceRow->serviceGroups()->associate($serviceGroup);
            }
            if (!$serviceRow->exists) {
                $this->airtableServiceRepository->store($serviceRow, $record);
            } else {
                $this->airtableServiceRepository->update($serviceRow, $record);
            }
        }
    }
}
