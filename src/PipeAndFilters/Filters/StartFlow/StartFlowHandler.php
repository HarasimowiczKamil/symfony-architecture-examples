<?php

namespace App\PipeAndFilters\Filters\StartFlow;

use App\PipeAndFilters\Filters\SomeFlowInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class StartFlowHandler
{
    public function __invoke(StartFlowStage $message): SomeFlowInterface
    {
        $data = $message->getData();

        $data['start_flow'] = 1;

        var_dump(__METHOD__, $data);
        $message->setData($data);

        return $message;
    }
}
