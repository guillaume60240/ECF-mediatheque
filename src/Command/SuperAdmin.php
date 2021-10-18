<?php

namespace App\Command;

use App\Services\User\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SuperAdmin extends Command
{
    protected $userService;

    protected static $defaultName = 'app:user:superadmin';

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Give all roles for super admin')
            ->addOption('dry-run', null, InputOption::VALUE_NONE, 'Dry run')
            ->addArgument('mail', InputArgument::REQUIRED, "Mail de l'utilisateur")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $mail = $input->getArgument('mail');
        $io = new SymfonyStyle($input, $output);

        if ($input->getOption('dry-run')) {
            $io->note('Dry mode enabled');

            $action = $this->userService->createSuperAdmin($mail);
        } else {
            $action = $this->userService->createSuperAdmin($mail);
        }

        $io->success(sprintf('Get "%s" superAdmin.', $mail));

        return 0;
    }
}