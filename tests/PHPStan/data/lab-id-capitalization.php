<?php declare(strict_types=1);

namespace MLL\Utils\Tests\PHPStan\data;

class LabIDCapitalizationTestFixture
{
    public function wrongCapitalizationInString(): string
    {
        return 'The LabID is wrong';
    }

    public function correctCapitalizationInString(): string
    {
        return 'The Lab ID is correct';
    }

    public function graphqlQueryIsIgnored(): string
    {
        return /* @lang GraphQL */ '
            {
                patient {
                    labID
                }
            }
        ';
    }

    public function graphqlQueryWithoutAnnotationIsChecked(): string
    {
        return '
            {
                patient {
                    labID
                }
            }
        ';
    }

    /** @return array<string, string> */
    public function arrayKeysAreIgnored(): array
    {
        // Array keys that look like identifiers should be ignored
        return [
            'labID' => 'some value',
            'LabID' => 'another value',
        ];
    }

    public function identifierStringsAreIgnored(): string
    {
        // Single identifier strings (no spaces) should be ignored
        $key = 'labID';

        return $key;
    }

    public function sqlQueryIsIgnored(): string
    {
        return /* @lang SQL */ '
            SELECT exam_no AS labID
            FROM examinations
            WHERE labID > 1000
        ';
    }

    public function sqlQueryWithoutAnnotationIsChecked(): string
    {
        return '
            SELECT exam_no AS labID
            FROM examinations
        ';
    }
}
