<?php

declare(strict_types=1);

namespace RDD\Lab1\Components\Command;

use RDD\Lab1\Components\HashService\Business\Model\RSAInterface;
use Shopware\Core\Framework\Adapter\Console\ShopwareStyle;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

class RsaCommand extends Command
{
    protected static $defaultName = 'Lab2:rsa';

    public function __construct(private readonly RSAInterface $RSA)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new ShopwareStyle($input, $output);
        $signature = '';

        $choiseQuestion = new ChoiceQuestion(
            'Would you like to encode or decode the phrase?',
            // choices can also be PHP objects that implement __toString() method
            ['encode', 'decode', 'sign', 'prove'],
            0
        );
        $choise = $io->askQuestion($choiseQuestion);

        if ($choise === 'prove') {
            $signatureQuestion = new Question('Please enter the message signature', false);
            $signature = $io->askQuestion($signatureQuestion);
        }

        $question = new Question('What phrase would you like to ' . $choise . '?', false);
        $phrase = $io->askQuestion($question);

        $questionP = new Question('What p-parameter would you like to use?', '9990454949');
        $pParameter = $io->askQuestion($questionP);

        $questionQ = new Question('What q-parameter would you like to use?', '9990450271');
        $qParameter = $io->askQuestion($questionQ);

        $questionDebug = new ConfirmationQuestion('Would you like to show debug information?');
        $debugParameter = $io->askQuestion($questionDebug);

        $keys = $this->RSA->generate_keys($pParameter, $qParameter, $debugParameter);

        $result = match ($choise) {
            'encode' => $this->RSA->encrypt($phrase, $keys[1], $keys[0], 5),
            'decode' => $this->RSA->decrypt($phrase, $keys[2], $keys[0]),
            'sign' => $this->RSA->sign($phrase, $keys[1], $keys[0]),
            'prove' => $this->RSA->prove($phrase, $signature, $keys[2], $keys[0])
        };

        if ($choise === 'prove') {
            $output->writeln('');
            $result ? $output->writeln('Signature successfully verified') : $output->writeln(
                'Signature verification failed'
            );
        } else {
            $breaks = array("<br />","<br>","<br/>", "</b>", "<br>", "<b>");

            $output->writeln('');
            $output->writeln('Message result:');
            $output->writeln(str_replace($breaks, "\r\n", $result));
        }


        return self::SUCCESS;
    }
}
