<?php declare(strict_types=1);

namespace MLL\Utils\FluidXPlate;

use Illuminate\Support\Str;
use MLL\Utils\Microplate\Coordinates;
use MLL\Utils\StringUtil;

/** Communicates with a FluidX scanner device and fetches results from it. */
class FluidXScanner
{
    private const READING = 'Reading...';
    private const XTR_96_CONNECTED = 'xtr-96 Connected';
    private const NO_READ = 'NO READ';
    private const NO_TUBE = 'NO TUBE';
    public const LOCALHOST = '127.0.0.1';

    public function scanPlate(string $ip): FluidXPlate
    {
        if ($ip === self::LOCALHOST) {
            return $this->returnTestPlate();
        }

        if ($ip === '') {
            throw new ScanFluidXPlateException('Cannot start scan request without an IP address.');
        }

        try {
            $socket = \Safe\fsockopen($ip, 8001, $errno, $errstr, 30);
        } catch (\Throwable $e) {
            throw new ScanFluidXPlateException("Cannot reach FluidX Scanner {$ip}: {$e->getMessage()}. Verify that the FluidX Scanner is turned on and the FluidX software is started.", 0, $e);
        }

        \Safe\fwrite($socket, "get\r\n");

        $answer = '';
        do {
            $content = fgets($socket);
            $answer .= $content;
        } while (is_string($content) && ! Str::contains($content, 'H12'));

        \Safe\fclose($socket);

        return self::parseRawContent($answer);
    }

    public static function parseRawContent(string $rawContent): FluidXPlate
    {
        if ($rawContent === '') {
            throw new ScanFluidXPlateException('Der Scanner lieferte ein leeres Ergebnis zurück.');
        }

        $lines = StringUtil::splitLines($rawContent);
        $barcodes = [];
        $id = null;
        foreach ($lines as $line) {
            if ($line === '' || $line === self::READING || $line === self::XTR_96_CONNECTED) {
                continue;
            }
            $content = explode(', ', $line);
            if (count($content) <= 3) {
                continue;
            }

            // All valid lines contain the same plate barcode
            $id = $content[3];
            if ($id === FluidXScanner::NO_READ && isset($content[4])) {
                $id = $content[4];
            }

            $barcodeScanResult = $content[1];
            $coordinatesString = $content[0];
            if ($barcodeScanResult !== self::NO_READ && $barcodeScanResult !== self::NO_TUBE) {
                $barcodes[$coordinatesString] = $barcodeScanResult;
            }
        }

        if (is_null($id)) {
            throw new ScanFluidXPlateException('Der Scanner lieferte keinen Plattenbarcode zurück.');
        }

        if ($id === FluidXScanner::NO_READ) {
            throw new ScanFluidXPlateException($barcodes === []
                ? 'Weder Platten-Barcode noch Tube-Barcodes konnten gescannt werden. Bitte überprüfen Sie, dass die Platte korrekt in den FluidX-Scanner eingelegt wurde.'
                : 'Platten-Barcode konnte nicht gescannt werden. Bitte überprüfen Sie, dass die Platte mit der korrekten Orientierung in den FluidX-Scanner eingelegt wurde.');
        }

        $plate = new FluidXPlate($id);
        $coordinateSystem = FluidXPlate::coordinateSystem();
        foreach ($barcodes as $coordinates => $barcode) {
            $plate->addWell(Coordinates::fromString($coordinates, $coordinateSystem), $barcode);
        }

        return $plate;
    }

    private function returnTestPlate(): FluidXPlate
    {
        return self::parseRawContent(\Safe\file_get_contents(__DIR__ . '/TestPlate.txt'));
    }
}
