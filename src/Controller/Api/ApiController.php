<?php

declare(strict_types=1);

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends AbstractController
{
    protected function isContentTypeEqualTo(string $expected, ?string $actual): ?Response
    {
        if ($actual !== $expected) {
            return new Response(sprintf(
                'Given content type "%s" is not expected. Expected content type is: %s',
                $actual,
                $expected
            ),
                Response::HTTP_BAD_REQUEST
            );
        }

        return null;
    }

    protected function internalServerErrorResponse(): Response
    {
        return new Response('We are sorry. Something went wrong.', Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    protected function getJsonContentTypeToAssocArray(Request $request): array
    {
        return json_decode($request->getContent(), true) ?? [];
    }

    protected function getJsonResponseWithMessage(string $message, int $status, array $headers = array(), bool $json = false): JsonResponse
    {
        return new JsonResponse([
            'message' => $message,
            'status' => $status
        ], $status, $headers, $json);
    }

    protected function checkForRequiredParametersInContent(array $parameters, array $content): void
    {
        foreach ($parameters as $parameter) {
            if (!array_key_exists($parameter, $content)) {
                throw new \InvalidArgumentException(sprintf(
                    'The "%s" parameter is required',
                    $parameter
                ));
            }
        }
    }
}