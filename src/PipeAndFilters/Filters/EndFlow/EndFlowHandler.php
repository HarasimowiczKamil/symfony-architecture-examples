<?php

namespace App\PipeAndFilters\Filters\EndFlow;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class EndFlowHandler
{
    public function __invoke(EndFlowStage $message): void
    {
        $data = $message->getData();

        $data['end'] = 1;

        var_dump(__METHOD__, $data);
    }
}
