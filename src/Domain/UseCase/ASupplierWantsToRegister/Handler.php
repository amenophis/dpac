<?php

declare(strict_types=1);

namespace App\Domain\UseCase\ASupplierWantsToRegister;

use App\Domain\Clock;
use App\Domain\Data\Model\Supplier;
use App\Domain\Data\Repository\Suppliers;
use App\Domain\IdGenerator;
use App\Domain\UseCase\UseCaseHandler;

class Handler implements UseCaseHandler
{
    private Suppliers $suppliers;
    private IdGenerator $idGenerator;
    private Clock $clock;

    public function __construct(Suppliers $suppliers, IdGenerator $idGenerator, Clock $clock)
    {
        $this->suppliers   = $suppliers;
        $this->idGenerator = $idGenerator;
        $this->clock       = $clock;
    }

    public function __invoke(Input $input): void
    {
        $supplier = Supplier::register($input->getName(), $input->getEmail(), $this->idGenerator, $this->clock);
        $this->suppliers->add($supplier);
    }
}
