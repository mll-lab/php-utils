<?php declare(strict_types=1);

namespace MLL\Utils\Tests\InterOp;

use MLL\Utils\InterOp\MetaInfo;
use MLL\Utils\InterOp\RunParameters;
use PHPUnit\Framework\TestCase;

use function Safe\file_get_contents;

final class MetaInfoTest extends TestCase
{
    public function testParseMiSeq(): void
    {
        $json = file_get_contents(__DIR__ . '/meta-info-miseq.json');
        $metaInfo = new MetaInfo($json);

        self::assertSame(RunParameters::APPLICATION_MISEQ, $metaInfo->runParameters->application);
        self::assertSame('2023-04-21', $metaInfo->runParameters->runDate->format('Y-m-d'));
        self::assertSame('KT6CY', $metaInfo->runParameters->flowcell);
        self::assertSame('2023-09-27', $metaInfo->runParameters->flowcellExpirationDate);
        self::assertSame('1.18.54', $metaInfo->runParameters->rta);
        self::assertSame('2.6.2.2', $metaInfo->runParameters->mcs);
        self::assertSame('230421_M02074_0859_000000000-KT6CY', $metaInfo->runParameters->info);

        self::assertCount(2, $metaInfo->runParameters->reagents);
        self::assertSame('MS3471919-00PR2', $metaInfo->runParameters->reagents[0]['name']);
        self::assertSame('2023-09-28', $metaInfo->runParameters->reagents[0]['expire_date']);
        self::assertSame('MS3233206-600V3', $metaInfo->runParameters->reagents[1]['name']);
        self::assertSame('2023-09-16', $metaInfo->runParameters->reagents[1]['expire_date']);

        self::assertSame(851.0, $metaInfo->interOpResult->resultsForRead1->clusterStatistic->density->value);
        self::assertSame(32.0, $metaInfo->interOpResult->resultsForRead1->clusterStatistic->density->deviation);
        self::assertSame(96.54, $metaInfo->interOpResult->resultsForRead1->clusterStatistic->clusterPF->value);
        self::assertSame(21.22, $metaInfo->interOpResult->resultsForRead1->clusterStatistic->clusterCount);
        self::assertSame(20.48, $metaInfo->interOpResult->resultsForRead1->clusterStatistic->clusterCountPF);

        self::assertSame(88.2, $metaInfo->interOpResult->resultsForRead1->sequencingQualityControl->q30);
        self::assertSame(0.085, $metaInfo->interOpResult->resultsForRead1->sequencingQualityControl->phasing);
        self::assertSame(0.02, $metaInfo->interOpResult->resultsForRead1->sequencingQualityControl->prephasing);
        self::assertSame(6.18, $metaInfo->interOpResult->resultsForRead1->sequencingQualityControl->aligned->value);
        self::assertSame(2.88, $metaInfo->interOpResult->resultsForRead1->sequencingQualityControl->error->value);
        self::assertSame(139, $metaInfo->interOpResult->resultsForRead1->intensityCycle);
        self::assertSame(6140000, $metaInfo->interOpResult->resultsForRead1->yield);

        self::assertSame(78.19, $metaInfo->interOpResult->resultsForRead2->sequencingQualityControl->q30);
        self::assertSame(0.045, $metaInfo->interOpResult->resultsForRead2->sequencingQualityControl->phasing);
        self::assertSame(46, $metaInfo->interOpResult->resultsForRead2->intensityCycle);
        self::assertSame(6140000, $metaInfo->interOpResult->resultsForRead2->yield);

        $runQC = $metaInfo->interOpResult->resultsForRun->sequencingQualityControl;
        self::assertEqualsWithDelta(83.195, $runQC->q30, 0.001);
        self::assertEqualsWithDelta(0.065, $runQC->phasing, 0.001);

        self::assertSame('mllsrv20/miseq_active\\230421_M02074_0859_000000000-KT6CY\\meta-info.json', $metaInfo->uncPath);
    }

    public function testParseMiSeqI100(): void
    {
        $json = file_get_contents(__DIR__ . '/meta-info-i100.json');
        $metaInfo = new MetaInfo($json);

        self::assertSame(RunParameters::APPLICATION_MISEQ_I100, $metaInfo->runParameters->application);
        self::assertSame('2026-02-05', $metaInfo->runParameters->runDate->format('Y-m-d'));
        self::assertSame('SC2139476-SC3', $metaInfo->runParameters->flowcell);
        self::assertSame('2026-07-29', $metaInfo->runParameters->flowcellExpirationDate);
        self::assertSame('', $metaInfo->runParameters->rta);
        self::assertSame('1.1.0.26158', $metaInfo->runParameters->mcs);
        self::assertSame('20260205_SH01038_0007_ASC2139476-SC3', $metaInfo->runParameters->info);

        self::assertCount(2, $metaInfo->runParameters->reagents);
        self::assertSame('SC2139476-SC3', $metaInfo->runParameters->reagents[0]['name']);
        self::assertSame('2026-07-29', $metaInfo->runParameters->reagents[0]['expire_date']);
        self::assertSame('SC2157208-SC2', $metaInfo->runParameters->reagents[1]['name']);
        self::assertSame('2026-10-17', $metaInfo->runParameters->reagents[1]['expire_date']);

        self::assertSame(1000.0, $metaInfo->interOpResult->resultsForRead1->clusterStatistic->density->value);
        self::assertSame(62.27, $metaInfo->interOpResult->resultsForRead1->clusterStatistic->clusterPF->value);
        self::assertSame(95.35, $metaInfo->interOpResult->resultsForRead1->sequencingQualityControl->q30);
        self::assertSame(0.075, $metaInfo->interOpResult->resultsForRead1->sequencingQualityControl->phasing);
        self::assertSame(0.042, $metaInfo->interOpResult->resultsForRead1->sequencingQualityControl->prephasing);
        self::assertSame(28.66, $metaInfo->interOpResult->resultsForRead1->sequencingQualityControl->aligned->value);
        self::assertSame(0.27, $metaInfo->interOpResult->resultsForRead1->sequencingQualityControl->error->value);
        self::assertSame(3534, $metaInfo->interOpResult->resultsForRead1->intensityCycle);
        self::assertSame(1490000, $metaInfo->interOpResult->resultsForRead1->yield);

        self::assertSame(96.32, $metaInfo->interOpResult->resultsForRead2->sequencingQualityControl->q30);
        self::assertSame(3486, $metaInfo->interOpResult->resultsForRead2->intensityCycle);
        self::assertSame(1490000, $metaInfo->interOpResult->resultsForRead2->yield);

        self::assertSame('mllsrv20/miseq_active\\miSeqi100\\20260205_SH01038_0007_ASC2139476-SC3\\meta-info.json', $metaInfo->uncPath);
    }
}
