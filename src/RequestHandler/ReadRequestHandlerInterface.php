<?php

namespace App\RequestHandler;

use App\Dto\AbstractDto;
use App\Dto\CollectionDtoInterface;

interface ReadRequestHandlerInterface extends RequestHandlerInterface
{
    /**
     * @return AbstractDto
     */
    public function read(): AbstractDto;

    /**
     * @return CollectionDtoInterface
     */
    public function readBatch(): CollectionDtoInterface;
}