<?php

declare(strict_types=1);

namespace ostark\Prompter\Services\TypeHintOutput;

class Twig implements TypeHintOutput
{
    public const QUERIES = [
        self::ENTRY_TYPE_QUERY => 'entries().type',
        self::ENTRY_SECTION_QUERY => 'entries().section',
        self::ASSET_QUERY => 'assets().volume',
    ];

    public function fullTemplate(string $handle, string $queryClass, string $elementClass): string
    {
        $var = $handle . 'Query';
        return <<<TWIG
            // Typehint the main Entry
            <fg=yellow>{# @var entry $elementClass #}</>           
            // entry.oneField
            // entry.anotherField
            
            // Typehint Entry queries
            <fg=yellow>{# @var $var $queryClass #}</>  
            
            <fg=yellow>         
            {% set <fg=blue>$var</> = <fg=blue>craft.entries().type('$handle')</> %}
            
            {% for <fg=blue>$handle</> in <fg=blue>$var.all()</> %}
                  
                  <fg=default>// $handle.oneField</>
                  <fg=default>// $handle.anotherField</>

                  {% for <fg=blue>matrix</> in <fg=blue>$handle.yourMatrixField</> %}
                      <fg=default>// matrix.oneMatrixField</>
                      <fg=default>// matrix.anotherMatrixField</>
                  {% endfor %}
                  
            {% endfor %}
            </>

            TWIG;
    }

    public function listTemplate(
        string $handle,
        string $queryClass,
        string $query = self::ENTRY_TYPE_QUERY
    ): string {
        $queryType = self::QUERIES[$query];

        return <<<TWIG
            
            <fg=yellow>
            {# @var query $queryClass #}            
            {% set <fg=blue>query</> = <fg=blue>craft.$queryType('$handle')</> %}</>
            <fg=default>// query.all() or query.one()</>
            </>
            TWIG;
    }

    public function listTemplateGlobalset(string $handle, string $class): string
    {
        return <<<TWIG
            
            <fg=yellow>
            {# @var $handle $class #}            
            </>
            TWIG;
    }
}
