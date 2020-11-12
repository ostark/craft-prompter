<?php

use ostark\Prompter\Services\TypeHintHelpGenerator;
use function Spatie\Snapshots\assertMatchesSnapshot;
use Tests\Mocks\ElementContextRepositoryMock;

function getGenerator(): TypeHintHelpGenerator
{
    return new TypeHintHelpGenerator(new ElementContextRepositoryMock());
}

test(
    'twig output for section type hints',
    function () {
        $twig = getGenerator()->setOutputFormat('twig')->section();
        assertMatchesSnapshot($twig);
    }
);

test(
    'twig output for asset type hints',
    function () {
        $twig = getGenerator()->setOutputFormat('twig')->asset();
        assertMatchesSnapshot($twig);
    }
);

test(
    'twig output for entry type hints',
    function () {
        $twig = getGenerator()->setOutputFormat('twig')->entry('pest');
        assertMatchesSnapshot($twig);
    }
);


test(
    'php output for section type hints',
    function () {
        $twig = getGenerator()->setOutputFormat('php')->section();
        assertMatchesSnapshot($twig);
    }
);

test(
    'php output for asset type hints',
    function () {
        $twig = getGenerator()->setOutputFormat('php')->asset();
        assertMatchesSnapshot($twig);
    }
);

test(
    'php output for entry type hints',
    function () {
        $twig = getGenerator()->setOutputFormat('php')->entry('pest');
        assertMatchesSnapshot($twig);
    }
);
