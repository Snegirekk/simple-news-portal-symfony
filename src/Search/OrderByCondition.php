<?php

namespace App\Search;

class OrderByCondition
{
    /**
     * @var string
     */
    private $field;

    /**
     * @var string|null
     */
    private $direction;

    /**
     * OrderByCondition constructor.
     *
     * @param string      $field
     * @param string|null $direction
     */
    public function __construct(string $field, ?string $direction = null)
    {
        $this->field = $field;
        $this->direction = $direction;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @return string|null
     */
    public function getDirection(): ?string
    {
        return $this->direction;
    }
}
