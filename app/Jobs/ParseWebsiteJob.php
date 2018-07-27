<?php

namespace App\Jobs;

use App\Repositories\OutageRepository;
use DOMDocument;
use DOMElement;
use DOMNode;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Jenssegers\Date\Date;

class ParseWebsiteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /** @var  OutageRepository */
    protected $outageRepository;


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(OutageRepository $outageRepository)
    {
        $this->outageRepository = $outageRepository;
        $html = file_get_contents(config('ceb.url'));

        $doc = new DOMDocument();
        $doc->loadHTML($html, LIBXML_NOERROR);

        $table = static::getOutagesTable($doc);

        static::saveOutages($table);

        /*$outages = new DOMDocument();
        $outages->appendChild($outages->importNode($table, true));

        \Log::debug($outages->saveHTML());*/
    }

    /**
     * @param DOMDocument $doc
     * @return DOMElement
     */
    protected function getOutagesTable($doc)
    {

        /** @var DOMElement $table */
        foreach ($doc->getElementsByTagName('table') as $table) {
            /** @var DOMNode $row */
            $row = $table->getElementsByTagName('tr')->item(0);

            /*\Log::debug($row->childNodes->length);
            \Log::debug($row->textContent);*/

            /*foreach($row->getElementsByTagName('td') as $node){
                \Log::debug(print_r($node, true));
            }*/

            /** @var \DOMNodeList $cells */
            $cells = $row->getElementsByTagName('td');

            if ($cells->length == 3
                && $cells->item(0)->textContent == config('ceb.outages_table.date')
                && $cells->item(1)->textContent == config('ceb.outages_table.locality')
                && $cells->item(2)->textContent == config('ceb.outages_table.road')
            ) {
                \Log::debug('found outages table');
                return $table;
            }
        }
    }

    /**
     * @param DOMElement $table
     */
    protected function saveOutages($table)
    {

        Date::setLocale('fr');

        $firstLine = true;
        /** @var DOMNode $row */
        foreach ($table->getElementsByTagName('tr') as $row) {
            if ($firstLine) {
                $firstLine = false;
                continue;
            }

            $hash = md5($row->textContent);

            if($this->outageRepository->findByField('hash', $hash)->count()) {
                continue;
            }

            $tds = $row->getElementsByTagName('td');

            list($date, $times) = explode(config('ceb.datetime_splitter'), $tds->item(0)->textContent);
            list($time_start, $time_end) = explode(config('ceb.time_splitter'), $times);

            \Log::debug('parsing "' . trim($date) . ' ' . trim($time_start) . '" with locale: ' . Date::getLocale());

            $start = Date::createFromFormat('Le l d F Y H:i', trim($date) . ' ' . trim($time_start));
            $end = Date::createFromFormat('Le l d F Y H:i', trim($date) . ' ' . trim($time_end));

            $this->outageRepository->create([
                'hash' => $hash,
                'outage_from' => $start,
                'outage_to' => $end,
                'locality' => trim($tds->item(1)->textContent),
                'roads' => trim($tds->item(2)->textContent),
            ]);

        }
    }


}
