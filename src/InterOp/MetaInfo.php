<?php declare(strict_types=1);

namespace MLL\Utils\InterOp;

use function Safe\json_decode;

/**
 * @phpstan-import-type MiSeqParams from RunParameters
 * @phpstan-import-type I100Params from RunParameters
 * @phpstan-type MetaInfoPayload array{
 *     runParameters: array{RunParameters: MiSeqParams|I100Params},
 *     interop: array{
 *         summary: array<int, array<string, string>>,
 *         reads: array<string, array<int, array<string, string>>>,
 *     },
 *     uncPath: string,
 * }
 */
class MetaInfo
{
    public RunParameters $runParameters;

    public InterOpResult $interOpResult;

    public string $uncPath;

    public function __construct(string $json)
    {
        /** @var MetaInfoPayload $data */
        $data = json_decode($json, true);

        $this->runParameters = new RunParameters($data['runParameters']['RunParameters']);
        $this->interOpResult = new InterOpResult($data['interop']['summary'], $data['interop']['reads']);
        $this->uncPath = $data['uncPath'];
    }
}
