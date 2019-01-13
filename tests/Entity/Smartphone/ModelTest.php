<?php

declare(strict_types=1);

namespace Tests\Model;

use App\Entity\Smartphone\Model;
use PHPUnit\Framework\TestCase;

class ModelTest extends TestCase
{
    /**
     * @expectedException App\Entity\Exception\Smartphone\UnknownCompanyException
     */
    public function testChoosingModelByNotExistingCompany(): void
    {
        Model::chooseFromList('Minifix', 'model');
    }

    /**
     * @expectedException App\Entity\Exception\Smartphone\UnknownModelException
     */
    public function testChoosingModelByNotExistingModel(): void
    {
        Model::chooseFromList(Model::COMPANIES[0], 'model');
    }
}
