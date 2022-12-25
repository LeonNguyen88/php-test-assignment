<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\DB;


class FetchAirtableService
{
    protected $airtableServiceService;

    protected $client;
    protected $airtableDrawingService;
    protected $airtableModelService;
    protected $airtableModelModelService;

    public function __construct(AirtableServiceService $airtableServiceService,
                                AirtableModelModelService $airtableModelModelService,
                                AirtableDrawingService $airtableDrawingService,
                                AirtableModelService $airtableModelService)
    {
        $this->airtableServiceService = $airtableServiceService;

        $this->client = new Client();
        $this->airtableDrawingService = $airtableDrawingService;
        $this->airtableModelModelService = $airtableModelModelService;
        $this->airtableModelService = $airtableModelService;
    }


    /**
     * @param string $name
     * @param string $offset
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(string $name = '', string $offset = ''): \Psr\Http\Message\ResponseInterface
    {
        return $this->client->request('GET', 'https://api.airtable.com/v0/' . config('app.airtable_base_id') . '/' . $name . '?offset=' . $offset,
            [

                'headers' => [
                    'Authorization' => 'Bearer ' . config('app.airtable_key')
                ]
            ]);
    }


    /**
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetch(): array
    {
        $types = ['models', 'services', 'drawings', 'model_model'];
        $records = [];
        foreach ($types as $type) {
                $records[$type] = [];
                $response = json_decode($this->request($type)->getBody(), true);
                $records[$type] = $response['records'];

                while (isset($response['offset'])) {
                    $records[$type] = array_merge($records[$type], $response['records']);
                    $response = json_decode($this->request($type, $response['offset'])->getBody(), true);
                    if (!isset($response['offset'])) {
                        $records[$type] = array_merge($records[$type], $response['records']);
                    }
                }
        }

        return $records;
    }

    /**
     * @param $records
     * @return void
     * @throws \Exception
     */
    public function store($records)
    {
        foreach ($records as $type => $record) {

            try {
                DB::beginTransaction();
                switch ($type) {
                    case 'services':
                        $this->airtableServiceService->store($record);
                        break;
                    case 'models':
                        $this->airtableModelService->store($record);
                        break;
                    case 'model_model':
                        $this->airtableModelModelService->store($record);
                        break;
                    case 'drawings':
                        $this->airtableDrawingService->store($record);
                        break;
                    default:
                        throw new \Exception('wrong airtable type');
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        }
    }
}
