<?php

declare(strict_types=1);

namespace App\Payroll\Infrastructure\Console;

use App\Payroll\Domain\Repository\ContractRepositoryInterface;
use App\Shared\Application\Event\EventBusInterface;
use App\Shared\Application\Event\RefreshPayrollEvent;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:refresh-all_contracts-payroll-projections',
    description: 'Refresh all contracts projections',
)]
final class RefreshAllContractsPayrollProjections extends Command
{
    public function __construct(
        private readonly ContractRepositoryInterface $contractRepository,
        private readonly EventBusInterface $eventBus
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $progressBar = new ProgressBar($output);
        foreach ($this->contractRepository->findAllContracts() as $contract) {
            $event = new RefreshPayrollEvent($contract->getUserId());
            $this->eventBus->dispatch($event);
            $progressBar->advance();
        }

        $progressBar->finish();

        return Command::SUCCESS;
    }
}
