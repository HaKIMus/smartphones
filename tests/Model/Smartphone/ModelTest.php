<?php

declare(strict_types=1);

namespace Tests\Model;

use App\Model\Smartphone\Model;
use PHPUnit\Framework\TestCase;

class ModelTest extends TestCase
{
    /**
     * @expectedException App\Model\Exception\Smartphone\UnknownCompanyException
     */
    public function testChoosingModelByNotExistingCompany(): void
    {
        Model::chooseFromList('Minifix', 'model');
    }

    /**
     * @expectedException App\Model\Exception\Smartphone\UnknownModelException
     */
    public function testChoosingModelByNotExistingModel(): void
    {
        Model::chooseFromList(Model::COMPANIES[0], 'model');
    }
}
