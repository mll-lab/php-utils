<?php declare(strict_types=1);

namespace MLL\Utils;

use function Safe\preg_match;

class VariantIdentifier
{
    public GenomicPosition $genomicPosition;

    public DnaSequence $reference;

    public DnaSequence $alternate;

    public function __construct(GenomicPosition $genomicPosition, DnaSequence $reference, DnaSequence $alternate)
    {
        $this->genomicPosition = $genomicPosition;
        $this->reference = $reference;
        $this->alternate = $alternate;
    }

    public static function parse(string $value): self
    {
        if (strpos($value, '/') !== false) {
            return self::parseCanonical($value);
        }

        return self::parseVCF($value);
    }

    public function toString(VariantIdentifierFormat $format, NamingConvention $namingConvention): string
    {
        $chromosome = $this->genomicPosition->chromosome->toString($namingConvention);
        $position = $this->genomicPosition->position;
        $ref = $this->reference->toString();
        $alt = $this->alternate->toString();

        switch ($format->value) {
            case VariantIdentifierFormat::VCF:
                return "{$chromosome}-{$position}-{$ref}-{$alt}";
            case VariantIdentifierFormat::CANONICAL:
                return "{$chromosome}-{$position}-{$ref}/{$alt}";
            case VariantIdentifierFormat::TAB:
                return "{$chromosome}\t{$position}\t{$ref}\t{$alt}";
            default:
                throw new \InvalidArgumentException("No toString logic implemented for format: {$format->value}.");
        }
    }

    private static function parseCanonical(string $value): self
    {
        if (preg_match('/^(.+)-(\d+)-([ATGC]+)\/([ATGC]+)$/i', $value, $matches) === 0) {
            throw new \InvalidArgumentException("Invalid canonical variant identifier format: {$value}.");
        }

        assert(isset($matches[1], $matches[2], $matches[3], $matches[4]));

        return new self(
            new GenomicPosition(new Chromosome($matches[1]), NucleotidePosition::fromOneBased(SafeCast::toInt($matches[2]))),
            new DnaSequence($matches[3]),
            new DnaSequence($matches[4])
        );
    }

    private static function parseVCF(string $value): self
    {
        if (preg_match('/^(.+)-(\d+)-([ATGC]+)-([ATGC]+)$/i', $value, $matches) === 0) {
            throw new \InvalidArgumentException("Invalid VCF variant identifier format: {$value}.");
        }

        assert(isset($matches[1], $matches[2], $matches[3], $matches[4]));

        return new self(
            new GenomicPosition(new Chromosome($matches[1]), NucleotidePosition::fromOneBased(SafeCast::toInt($matches[2]))),
            new DnaSequence($matches[3]),
            new DnaSequence($matches[4])
        );
    }
}
