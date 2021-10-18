<?php

namespace App\Command;

use App\Services\User\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UsersCleanUp extends Command
{
    protected $userService;

    protected static $defaultName = 'app:users:cleanup';

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Deletes non validate users from the database')
            ->addOption('dry-run', null, InputOption::VALUE_NONE, 'Dry run')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if ($input->getOption('dry-run')) {
            $io->note('Dry mode enabled');

            $count = $this->userService->removeNonValidateUser();
        } else {
            $count = $this->userService->removeNonValidateUser();
        }

        $io->success(sprintf('Deleted "%d" non validate users.', $count));

        return 0;
    }
}