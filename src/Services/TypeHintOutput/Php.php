<?php

declare(strict_types=1);

namespace ostark\Prompter\Services\TypeHintOutput;

class Php implements TypeHintOutput
{
    public const QUERIES = [
        self::ENTRY_TYPE_QUERY => 'Entry::find()->type',
        self::ENTRY_SECTION_QUERY => 'Entry::find()->section',
        self::ASSET_QUERY => 'Asset::find()->volume',
    ];

    public function fullTemplate(string $handle, string $queryClass, string $elementClass): string
    {
        $var = '$' . $handle . 'Query';
        return <<<PHP
            
            // Typehint Entry queries
            <fg=yellow>
            /** @var $var $queryClass */
            <fg=blue>{$var}</> = <fg=blue>\\craft\\elements\\Entry::find()->type('$handle');</>
            
            foreach(<fg=blue>{$var}->all()</> as <fg=blue>\${$handle}</>) {
                  
                <fg=default>// \${$handle}->oneField</>
                <fg=default>// \${$handle}->anotherField</>

                foreach(<fg=blue>\${$handle}->someMatrixField</> as <fg=blue>\$matrix</>) {
                  
                    <fg=default>// \$matrix->oneField</>
                    <fg=default>// \$matrix->anotherField</>
                }          
            }
            </>

            PHP;
    }

    public function listTemplate(
        string $handle,
        string $queryClass,
        string $query = self::ENTRY_TYPE_QUERY
    ): string {
        $queryType = self::QUERIES[$query];

        return <<<PHP
            
            <fg=yellow>
            /** @var query $queryClass */           
            <fg=blue>\$query</> = <fg=blue>\\craft\\elements\\$queryType('$handle');</>
            <fg=default>// \$query->all() or \$query->one()</>
            </>
            PHP;
    }

    public function listTemplateGlobalset(string $handle, string $class): string
    {
        return <<<PHP
            
            <fg=yellow>
            /** @var $handle $class */            
            </>
            PHP;
    }
}
