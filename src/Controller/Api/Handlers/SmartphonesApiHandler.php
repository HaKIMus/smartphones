<?php

declare(strict_types=1);

namespace App\Controller\Api\Handlers;

use App\Controller\Api\Smartphones\SmartphonesApi;
use App\Entity\Exception\InvalidArgumentException as EntityInvalidArgumentException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class SmartphonesApiHandler
{
    /**
     * @see SmartphonesApi::getSmarthpones()
     * @see SmartphonesApi::getSmartphone()
     */
    public function readExceptionsHandler(callable $codeToHandle): Response
    {
        try {
            return $codeToHandle();
        } catch (\InvalidArgumentException $invalidArgumentException) {
            return $this->returnResponse([
                'message' => $invalidArgumentException->getMessage(),
                'status' => Response::HTTP_BAD_REQUEST,
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @see SmartphonesApi::postSmartphones()
     * @see SmartphonesApi::putSmartphone()
     * @see SmartphonesApi::deleteSmartphone()
     */
    public function writeExceptionsHandler(callable $codeToHandle): Response
    {
        try {
            return $codeToHandle();
        } catch (EntityInvalidArgumentException $invalidArgumentException) {
            return $this->returnResponse([
                'message' => $invalidArgumentException->getMessage(),
                'status' => Response::HTTP_BAD_REQUEST,
            ], Response::HTTP_BAD_REQUEST);
        } catch (\InvalidArgumentException | InvalidUuidStringException $invalidArgumentException) {
            return $this->returnResponse([
                'message' => $invalidArgumentException->getMessage(),
                'status' => Response::HTTP_BAD_REQUEST,
            ], Response::HTTP_BAD_REQUEST);
        } catch (UniqueConstraintViolationException $uniqueConstraintViolationException) {
            return $this->returnResponse([
                'message' => 'Given id is not unique',
                'status' => Response::HTTP_BAD_REQUEST,
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    private function returnResponse(array $message, int $status = Response::HTTP_BAD_REQUEST, string $responseType = 'json'): Response
    {
        switch ($responseType) {
            case 'json':
                return new JsonResponse($message, $status);
                break;
            default:
                return new JsonResponse($message, $status);
        }
    }
}