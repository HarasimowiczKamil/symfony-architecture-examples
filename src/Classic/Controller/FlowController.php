<?php

namespace App\Classic\Controller;

use App\PipeAndFilters\Filters\StartFlow\StartFlowStage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class FlowController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $flowBus,
    ) {
    }

    #[Route('/flow', name: 'app_flow')]
    public function index(): Response
    {
        ob_start();
        echo "Start\n";
        $this->flowBus->dispatch(
            new StartFlowStage(
                'test1',
                ['metadata' => ['id' => 3]]
            )
        );

        var_dump(__METHOD__);
        $out2 = ob_get_clean();

        return new Response("$out2\n" . 'end', 404, [
            'Content-Type' => 'text/plain',
        ]);
    }
}
