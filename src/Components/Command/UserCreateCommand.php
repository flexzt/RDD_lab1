<?php

declare(strict_types=1);

namespace RDD\Lab1\Components\Command;

use RDD\Lab1\Components\HashService\Business\Model\HashServiceHandlerInterface;
use RDD\Lab1\Components\HashService\Business\Model\Rsa;
use Shopware\Core\Framework\Adapter\Console\ShopwareStyle;
use Shopware\Core\Maintenance\User\Service\UserProvisioner;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class UserCreateCommand extends Command
{
    protected static $defaultName = 'userLab1:create';

    public function __construct(private readonly HashServiceHandlerInterface $hashServiceHandler)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
//        $this
//            ->addArgument('username', InputArgument::REQUIRED, 'Username for the user')
//            ->addOption('password', 'p', InputOption::VALUE_REQUIRED, 'Password for the user')
//            ->addOption('firstName', null, InputOption::VALUE_REQUIRED, 'The user\'s firstname')
//            ->addOption('lastName', null, InputOption::VALUE_REQUIRED, 'The user\'s lastname')
//            ->addOption('email', null, InputOption::VALUE_REQUIRED, 'E-Mail for the user');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new ShopwareStyle($input, $output);

        $username = $input->getArgument('username');
        $password = $input->getOption('password');

        if (!$password) {
            $passwordQuestion = new Question('Enter password for user');
            $passwordQuestion->setValidator(static function ($value): string {
                if ($value === null || trim($value) === '') {
                    throw new \RuntimeException('The password cannot be empty');
                }

                return $value;
            });
            $passwordQuestion->setHidden(true);
            $passwordQuestion->setMaxAttempts(3);

            $password = $io->askQuestion($passwordQuestion);
        }

        $additionalData = [];
        if ($input->getOption('lastName')) {
            $additionalData['lastName'] = $input->getOption('lastName');
        }
        if ($input->getOption('firstName')) {
            $additionalData['firstName'] = $input->getOption('firstName');
        }
        if ($input->getOption('email')) {
            $additionalData['email'] = $input->getOption('email');
        }

        $this->hashServiceHandler->provision($username, $password, $additionalData);

        $io->success(sprintf('User "%s" successfully created.', $username));

        return self::SUCCESS;
    }
}
