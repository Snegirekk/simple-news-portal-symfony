<?php

namespace App\RequestHandler;

use App\Dto\AbstractDto;

interface WriteRequestHandlerInterface extends RequestHandlerInterface
{
    /**
     * @param AbstractDto $data
     */
    public function write(AbstractDto $data): void;

    /**
     * @param iterable $data
     */
    public function writeBatch(iterable $data): void;

    /**
     * @param AbstractDto $data
     */
    public function delete(AbstractDto $data): void;

    /**
     * @param iterable $data
     */
    public function deleteBatch(iterable $data): void;
}