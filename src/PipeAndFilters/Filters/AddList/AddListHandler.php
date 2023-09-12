<?php

namespace App\PipeAndFilters\Filters\AddList;

use App\PipeAndFilters\Filters\SomeFlowInterface;
use App\PipeAndFilters\Filters\StartFlow\StartFlowStage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class AddListHandler
{
    public function __invoke(AddListStage $message): SomeFlowInterface
    {
        $data = $message->getData();

        $data['list'] = [
            ['id' => 1, 'name' => 'one'],
            ['id' => 2, 'name' => 'two'],
            ['id' => 3, 'name' => 'three'],
        ];

        var_dump(__METHOD__, $data);
        $message->setData($data);

        return $message;
    }
}
