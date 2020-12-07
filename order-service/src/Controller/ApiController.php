<?php

namespace App\Controller;

use App\Api\OrderReader\OrderReaderInterface;
use App\Api\OrderWriter\OrderWriterInterface;
use Shared\ApiGeneralBundle\Exception\Resource\ResourceExceptionInterface;
use Shared\OrderDto\Dto\Order;
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
     * @var OrderWriterInterface
     */
    private $orderWriter;

    /**
     * @var OrderReaderInterface
     */
    private $orderReader;

    /**
     * @param SerializerInterface $serializer
     * @param OrderWriterInterface $orderWriter
     * @param OrderReaderInterface $orderReader
     */
    public function __construct(
        SerializerInterface $serializer,
        OrderWriterInterface $orderWriter,
        OrderReaderInterface $orderReader
    ) {
        $this->serializer = $serializer;
        $this->orderWriter = $orderWriter;
        $this->orderReader = $orderReader;
    }

    /**
     * @Route("/api/order", methods={"POST"})
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function createOrder(Request $request): JsonResponse
    {
        /**
         * @var Order $order
         */
        $order = $this->serializer->deserialize((string)$request->getContent(), Order::class, 'json');

        try {
            $order = $this->orderWriter->createOrder($order);
        } catch (ResourceExceptionInterface $resourceException) {
            return $this->buildErrorResponse($resourceException, $resourceException->getHttpResponseCode());
        } catch (Throwable $genericException) {
            return $this->buildErrorResponse($genericException, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->buildResponse($order, Response::HTTP_CREATED);
    }

    /**
     * @Route("/api/order/{uuid}", methods={"GET"})
     *
     * @param string $uuid
     *
     * @return JsonResponse
     */
    public function findOrder(string $uuid): JsonResponse
    {
        try {
            $product = $this->orderReader->findOrder($uuid);
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
