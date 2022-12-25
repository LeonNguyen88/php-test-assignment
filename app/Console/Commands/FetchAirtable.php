<?php

namespace App\Console\Commands;

use App\Services\FetchAirtableService;
use Illuminate\Console\Command;

class FetchAirtable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:airtable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch records airbase';

    /**
     * Execute the console command.
     *
     * @param FetchAirtableService $fetchAirtableService
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(FetchAirtableService $fetchAirtableService)
    {
        try {
            $records = $fetchAirtableService->fetch();

            $fetchAirtableService->store($records);
        } catch (\Exception $e) {
            $this->info($e->getMessage());
        }


        $this->info('airtable store successfully');

    }
}
