<?php

namespace App\Controller;

use App\Service\DataMergerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

#[Route('/api/properties')]
final class PropertiesController extends AbstractController
{
    #[Route('', name: 'app_properties', methods: ['GET'])]
    public function index(CacheInterface $cache, DataMergerService $dataMergerService): JsonResponse
    {
        // Get the response from the cache
        $response = $cache->get('get-merged-properties', function(ItemInterface $item) use ($dataMergerService) {
            $item->expiresAfter(3600); // Expires at 1hr
            return $dataMergerService->getMergedDataResponse();
        });

        return $this->json($response);
    }
}
