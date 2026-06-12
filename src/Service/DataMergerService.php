<?php

namespace App\Service;

use App\DTO\PropertyDTO;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\SerializerInterface;

class DataMergerService
{
    public function __construct(
        #[Autowire('%kernel.project_dir%/public/data')]
        private readonly string $dataDir,
        private SerializerInterface $serializer,
    ) {}

    public function getMergedData(array $filenames = ['data1.json', 'data2.json']): array
    {
        $merged = [];

        foreach ($filenames as $filename) {
            $path = $this->dataDir . DIRECTORY_SEPARATOR . $filename;

            if (!is_file($path)) {
                throw new \RuntimeException(
                    sprintf('Data file not found: "%s"', $path)
                );
            }

            $raw = file_get_contents($path);
            // deserialize json data into DTO
            $propertyDTO = $this->serializer->deserialize($raw, PropertyDTO::class . '[]', 'json');

            $merged = array_merge($merged, $propertyDTO);
        }

        return $merged;
    }

    public function getMergedDataResponse(array $filenames = ['data1.json', 'data2.json']): array
    {
        try {
            $data = $this->getMergedData($filenames);
            $response = [
                'success' => true,
                'count'   => count($data),
                'data'    => $data,
            ];

            return $response;
        } catch (\Exception $e) {
            throw new NotFoundHttpException('Error getting data');
        }
    }
}
