<?php

namespace App\RequestHandler\Operation;

abstract class Operation
{
    /**
     * @var string
     */
    protected $dataType;

    /**
     * Operation constructor.
     * @param string $dataType
     */
    public function __construct(string $dataType)
    {
        $this->dataType = $dataType;
    }

    /**
     * @return string
     */
    public function getDataType(): string
    {
        return $this->dataType;
    }

}