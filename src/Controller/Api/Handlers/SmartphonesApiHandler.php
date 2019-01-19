<?php

declare(strict_types=1);

namespace App\Controller\Api\Handlers;

use App\Controller\Api\Smartphones\SmartphonesApi;
use App\Entity\Exception\Smartphone\ReleasedTooLateException;
use App\Entity\Exception\Smartphone\UnknownCompanyException;
use App\Entity\Exception\Smartphone\UnknownModelException;
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
    public static function readExceptionsHandler(callable $codeToHandle): Response
    {
        try {
            return $codeToHandle();
        } catch (\InvalidArgumentException $invalidArgumentException) {
            return self::returnResponse([
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
    public static function writeExceptionsHandler(callable $codeToHandle): Response
    {
        try {
            return $codeToHandle();
        } catch (ReleasedTooLateException | UnknownCompanyException | UnknownModelException $smartphoneException) {
            return self::returnResponse([
                'message' => $smartphoneException->getMessage(),
                'status' => Response::HTTP_BAD_REQUEST,
            ], Response::HTTP_BAD_REQUEST);
        } catch (\InvalidArgumentException | InvalidUuidStringException $invalidArgumentException) {
            return self::returnResponse([
                'message' => $invalidArgumentException->getMessage(),
                'status' => Response::HTTP_BAD_REQUEST,
            ], Response::HTTP_BAD_REQUEST);
        } catch (UniqueConstraintViolationException $uniqueConstraintViolationException) {
            return self::returnResponse([
                'message' => 'Given id is not unique',
                'status' => Response::HTTP_BAD_REQUEST,
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    private static function returnResponse(array $message, int $status = Response::HTTP_BAD_REQUEST, string $responseType = 'json'): Response
    {
        switch ($responseType) {
            case 'json':
                return new JsonResponse($message, $status);
                break;
            default:
                return new JsonResponse(['message' => 'Something went wrong!'], $status);
        }
    }
}