<?php

declare(strict_types=1);

namespace App\UI\Cli;

use App\Application\Command\SendNotification\SendNotificationCommand;
use App\Application\DTO\CustomerDTO;
use App\Application\DTO\MessageDTO;
use Faker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class TestCliCommand extends Command
{
    public function __construct(
        private MessageBusInterface $commandBus
    ) {
        parent::__construct('test:cli:command');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $faker = Faker\Factory::create();

        $command = new SendNotificationCommand(
            $faker->uuid(),
            new MessageDTO(
                'Message title',
                'I want to send this message ;)'
            ),
            new CustomerDTO(
                $faker->uuid(),
                'maciej.jan.tomczak@gmail.com',
                '+48509421774'
            )
        );

        $this->commandBus->dispatch($command);

        return 0;
    }
}
