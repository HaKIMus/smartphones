<?php

declare(strict_types=1);

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends AbstractController
{
    protected function isContentTypeEqualTo(string $expected, string $acutal): ?Response
    {
        if ($acutal !== $expected) {
            return new Response(sprintf(
                'Given content type "%s" is not expected. Expected content type is: %s',
                $acutal,
                $expected
            ),
                Response::HTTP_NOT_ACCEPTABLE
            );
        }

        return null;
    }

    protected function internalServerErrorResponse(): Response
    {
        return new Response('We are sorry. Something went wrong.', Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}