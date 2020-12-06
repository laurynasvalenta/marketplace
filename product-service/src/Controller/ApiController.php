<?php

namespace App\Controller;

use App\Api\ProductReader\ProductReaderInterface;
use App\Api\ProductWriter\ProductWriterInterface;
use Shared\ApiGeneralBundle\Exception\Resource\ResourceExceptionInterface;
use Shared\ProductDto\Dto\Product;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class ApiController
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var ProductWriterInterface
     */
    private $productWriter;

    /**
     * @var ProductReaderInterface
     */
    private $productReader;

    /**
     * @param SerializerInterface $serializer
     * @param ProductWriterInterface $productWriter
     * @param ProductReaderInterface $productReader
     */
    public function __construct(
        SerializerInterface $serializer,
        ProductWriterInterface $productWriter,
        ProductReaderInterface $productReader
    ) {
        $this->serializer = $serializer;
        $this->productWriter = $productWriter;
        $this->productReader = $productReader;
    }

    /**
     * @Route("/api/product", methods={"POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function createProduct(Request $request): JsonResponse
    {
        /**
         * @var Product $product
         */
        $product = $this->serializer->deserialize((string)$request->getContent(), Product::class, 'json');

        try {
            $product = $this->productWriter->createProduct($product);
        } catch (ResourceExceptionInterface $resourceException) {
            return $this->buildErrorResponse($resourceException, $resourceException->getHttpResponseCode());
        } catch (Throwable $genericException) {
            return $this->buildErrorResponse($genericException, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->buildResponse($product, Response::HTTP_CREATED);
    }

    /**
     * @Route("/api/product/{uuid}", methods={"GET"})
     *
     * @param string $uuid
     * @return JsonResponse
     */
    public function findProduct(string $uuid): JsonResponse
    {
        try {
            $product = $this->productReader->findProduct($uuid);
        } catch (ResourceExceptionInterface $resourceException) {
            return $this->buildErrorResponse($resourceException, $resourceException->getHttpResponseCode());
        } catch (Throwable $genericException) {
            return $this->buildErrorResponse($genericException, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->buildResponse($product, Response::HTTP_OK);
    }

    /**
     * @param Throwable $exception
     * @param int $responseCode
     *
     * @return JsonResponse
     */
    private function buildErrorResponse(Throwable $exception, int $responseCode): JsonResponse
    {
        return new JsonResponse($this->serializer->serialize($exception, 'json'), $responseCode, [], true);
    }

    /**
     * @param object $object
     * @param int $responseCode
     *
     * @return JsonResponse
     */
    private function buildResponse(object $object, int $responseCode): JsonResponse
    {
        return new JsonResponse($this->serializer->serialize($object, 'json'), $responseCode, [], true);
    }
}
