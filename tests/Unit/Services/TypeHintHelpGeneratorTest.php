<?php

use ostark\Prompter\Services\TypeHintHelpGenerator;
use Tests\Mocks\ElementContextRepositoryMock;

uses(\Spatie\Snapshots\MatchesSnapshots::class);

function getGenerator(): TypeHintHelpGenerator
{
    return new TypeHintHelpGenerator(new ElementContextRepositoryMock());
}

test(
    'twig output for section type hints',
    function () {
        $twig = getGenerator()->setOutputFormat('twig')->section();
        $this->assertMatchesSnapshot($twig);
    }
);

test(
    'twig output for asset type hints',
    function () {
        $twig = getGenerator()->setOutputFormat('twig')->asset();
        $this->assertMatchesSnapshot($twig);
    }
);

test(
    'twig output for entry type hints',
    function () {
        $twig = getGenerator()->setOutputFormat('twig')->entry('pest');
        $this->assertMatchesSnapshot($twig);
    }
);


test(
    'php output for section type hints',
    function () {
        $twig = getGenerator()->setOutputFormat('php')->section();
        $this->assertMatchesSnapshot($twig);
    }
);

test(
    'php output for asset type hints',
    function () {
        $twig = getGenerator()->setOutputFormat('php')->asset();
        $this->assertMatchesSnapshot($twig);
    }
);

test(
    'php output for entry type hints',
    function () {
        $twig = getGenerator()->setOutputFormat('php')->entry('pest');
        $this->assertMatchesSnapshot($twig);
    }
);
