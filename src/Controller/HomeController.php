<?php

declare(strict_types=1);

namespace App\Controller;

use App\Application\Command\UpdateSmartphoneCommand;
use App\Application\Handler\UpdateSmartphoneHandler;
use App\Infrastructure\Doctrine\Dbal\Repository\Smartphone\WriteSmartphoneRepository;
use App\Model\Smartphone\Id;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{
    /**
     * @Route("/")
     */
    public function index(WriteSmartphoneRepository $repository): Response
    {
        return new Response('smile');
    }
}