<?php

namespace App\PipeAndFilters\Middleware;

use App\PipeAndFilters\Filters\SomeFlowInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class RunNextMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly MessageBusInterface $flowBus,
        private array $flows,
    ) {
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {

        $stage = $envelope->getMessage();
        if (!$stage instanceof SomeFlowInterface) {
            throw new \RuntimeException('Bad Interface');
        }
        $resultEnvelope = $stack->next()->handle($envelope, $stack);
        /** @var SomeFlowInterface $result */
        $result = $resultEnvelope->last(HandledStamp::class)->getResult();

        $stageName = $this->getNextStage($stage);
        if ($stageName) {
            $this->flowBus->dispatch(new $stageName($result->getFlow(), $result->getData()));
        }

        return $resultEnvelope;
    }

    private function getNextStage(SomeFlowInterface $currentStage): ?string
    {
        $flow = $this->flows[$currentStage->getFlow()];
        while ($stage = current($flow)) {
            if ($currentStage instanceof $stage) {
                return next($flow);
            }
            next($flow);
        }
        return null;
    }
}
