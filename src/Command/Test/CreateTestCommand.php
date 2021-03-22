<?php

namespace App\Command\Test;

use App\Common\CommandInterface;

final class CreateTestCommand implements CommandInterface
{
    /**
     * @var array
     */
    private $answers;

    private $productionPath;

    private $owner;



    public function __construct(array $answers, string $productionPath, $owner)
    {
        $this->answers = $answers;
        $this->productionPath = $productionPath;
        $this->owener = $owner;
    }

    public function getAnswers(): array
    {
        return $this->answers;
    }

    public function getOwner()
    {
        return $this->owner;
    }

    public function getProductionPath()
    {
        return $this->productionPath;
    }
}
