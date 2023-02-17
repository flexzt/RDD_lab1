<?php

declare(strict_types=1);

namespace RDD\Lab1\Components\Command;

use RDD\Lab1\Components\HashService\Business\Model\HashServiceHandlerInterface;
use Shopware\Core\Framework\Adapter\Console\ShopwareStyle;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class UserValidateCommand extends Command
{
    protected static $defaultName = 'userLab1:validate';

    public function __construct(
        private readonly HashServiceHandlerInterface $hashServiceHandler,
        private readonly EntityRepository $userLabRepository
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new ShopwareStyle($input, $output);

        $question = new Question('Please enter your email', false);
        $email = $io->askQuestion($question);

        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('email', $email))->setLimit(1);

        $searchResult = $this->userLabRepository->search($criteria, Context::createDefaultContext());

        if (!$searchResult->getEntities()->count()) {
            $io->success(sprintf('User "%s" is not valid.', $email));

            return self::FAILURE;
        }

        $question = new Question('Please enter your password', false);
        $password = $io->askQuestion($question);

        $validated = $this->hashServiceHandler->validate($searchResult->getEntities()->first(), $password);

        if (!$validated) {
            $io->success(sprintf('User "%s" is not valid.', $email));
        }

        $io->success(sprintf('User "%s" is not valid.', $email));

        return self::SUCCESS;
    }
}
