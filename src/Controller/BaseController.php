<?php

namespace App\Controller;

use App\RequestHandler\RequestHandlerLocatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class BaseController extends AbstractController
{
    /**
     * @var RequestHandlerLocatorInterface
     */
    protected $requestHandlerLocator;

    /**
     * BaseController constructor.
     * @param RequestHandlerLocatorInterface $requestHandlerLocator
     */
    public function __construct(RequestHandlerLocatorInterface $requestHandlerLocator)
    {
        $this->requestHandlerLocator = $requestHandlerLocator;
    }

}