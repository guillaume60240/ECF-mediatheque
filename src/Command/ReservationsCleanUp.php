<?php

namespace App\Command;

use App\Services\Location\LocationService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ReservationsCleanUp extends Command
{
    protected $locationService;

    protected static $defaultName = 'app:reservations:cleanup';

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Deletes non validate reservations from the database')
            ->addOption('dry-run', null, InputOption::VALUE_NONE, 'Dry run')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if ($input->getOption('dry-run')) {
            $io->note('Dry mode enabled');

            $count = $this->locationService->removeNonValidateReservation();
        } else {
            $count = $this->locationService->removeNonValidateReservation();
        }

        $io->success(sprintf('Deleted "%d" non validate reservations.', $count));

        return 0;
    }
}