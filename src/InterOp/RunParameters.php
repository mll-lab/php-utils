<?php declare(strict_types=1);

namespace MLL\Utils\InterOp;

use Carbon\Carbon;

/**
 * @phpstan-type RFIDTag array{SerialNumber: string, PartNumber: int, ExpirationDate: string}
 * @phpstan-type MiSeqParams array{Setup: array{ApplicationName: string}, RunID: string, MCSVersion: string, RTAVersion: string, RunStartDate: int, FlowcellRFIDTag: RFIDTag, PR2BottleRFIDTag?: RFIDTag, ReagentKitRFIDTag?: RFIDTag}
 * @phpstan-type Consumable array{SerialNumber: string, Type: string, ExpirationDate?: string, LotNumber?: int, PartNumber?: int, Mode?: string|int, Version?: int}
 * @phpstan-type I100Params array{Application: string, RunId: string, SystemSuiteVersion: string, ConsumableInfo: array{ConsumableInfo: array<int, Consumable>}}
 */
class RunParameters
{
    public const APPLICATION_MISEQ = 'MiSeq Control Software';
    public const APPLICATION_MISEQ_I100 = 'MiSeqi100Series Control Software';

    public string $application;

    public Carbon $runDate;

    public string $flowcell;

    public ?string $flowcellExpirationDate = null;

    public ?string $realTimeAnalysisVersion = null;

    public string $info;

    public string $controlSoftwareVersion;

    /** @var array<int, array{name: string, expire_date: string}> */
    public array $reagents;

    /** @param MiSeqParams|I100Params $params */
    public function __construct(array $params)
    {
        if (isset($params['Setup']['ApplicationName'])) {
            $this->parseMiSeq($params);
        } elseif (isset($params['Application'])) {
            $this->parseMiSeqI100($params);
        } else {
            throw new InterOpException('Unable to determine device type from RunParameters.');
        }
    }

    /** @param MiSeqParams $params */
    private function parseMiSeq(array $params): void
    {
        $this->application = $params['Setup']['ApplicationName'];
        $this->info = $params['RunID'];
        $this->controlSoftwareVersion = $params['MCSVersion'];
        $this->realTimeAnalysisVersion = $params['RTAVersion'];

        $runStartDate = (string) $params['RunStartDate'];
        $date = Carbon::createFromFormat('!ymd', $runStartDate);
        assert($date instanceof Carbon, "Failed to parse MiSeq RunStartDate: {$runStartDate}.");
        $this->runDate = $date;

        $this->flowcell = $this->stripZeroPrefix($params['FlowcellRFIDTag']['SerialNumber']);
        $this->flowcellExpirationDate = $this->formatExpirationDate($params['FlowcellRFIDTag']['ExpirationDate']);

        $this->reagents = [];

        if (isset($params['PR2BottleRFIDTag'])) {
            $this->reagents[] = [
                'name' => $params['PR2BottleRFIDTag']['SerialNumber'],
                'expire_date' => $this->formatExpirationDate($params['PR2BottleRFIDTag']['ExpirationDate']),
            ];
        }

        if (isset($params['ReagentKitRFIDTag'])) {
            $this->reagents[] = [
                'name' => $params['ReagentKitRFIDTag']['SerialNumber'],
                'expire_date' => $this->formatExpirationDate($params['ReagentKitRFIDTag']['ExpirationDate']),
            ];
        }
    }

    /** @param I100Params $params */
    private function parseMiSeqI100(array $params): void
    {
        $this->application = $params['Application'];
        $this->info = $params['RunId'];
        $this->controlSoftwareVersion = $params['SystemSuiteVersion'];
        $this->realTimeAnalysisVersion = null;

        $dateString = substr($this->info, 0, 8);
        $date = Carbon::createFromFormat('!Ymd', $dateString);
        assert($date instanceof Carbon, "Failed to parse i100 run date from RunId: {$this->info}.");
        $this->runDate = $date;

        $consumables = $params['ConsumableInfo']['ConsumableInfo'];
        $this->flowcell = '';
        $this->flowcellExpirationDate = null;
        $this->reagents = [];

        foreach ($consumables as $consumable) {
            $type = $consumable['Type'];

            if ($type === 'DryCartridge' || $type === 'WetCartridge') {
                $this->reagents[] = [
                    'name' => $consumable['SerialNumber'],
                    'expire_date' => isset($consumable['ExpirationDate'])
                        ? $this->formatExpirationDate($consumable['ExpirationDate'])
                        : '',
                ];

                if ($type === 'DryCartridge') {
                    $this->flowcell = $consumable['SerialNumber'];
                    if (isset($consumable['ExpirationDate'])) {
                        $this->flowcellExpirationDate = $this->formatExpirationDate($consumable['ExpirationDate']);
                    }
                }
            }
        }
    }

    private function stripZeroPrefix(string $serial): string
    {
        $pos = strpos($serial, '-');
        if ($pos === false) {
            return $serial;
        }

        $prefix = substr($serial, 0, $pos);
        if ($prefix !== '' && trim($prefix, '0') === '') {
            return substr($serial, $pos + 1);
        }

        return $serial;
    }

    private function formatExpirationDate(string $dateTime): string
    {
        $date = Carbon::parse($dateTime);

        return $date->format('Y-m-d');
    }
}
