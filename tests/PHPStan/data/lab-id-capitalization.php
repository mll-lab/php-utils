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
}
