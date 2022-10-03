<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use App\Entity\Village;
use App\Repository\VillageRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;

#[AsCommand(
    name: 'app:show-cards-of-village',
    description: 'Add a short description for your command',
)]
class ShowCardsOfVillageCommand extends Command
{
    /**
     * @var VillageRepository
     */
    private $villageRepository;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->villageRepository = $container->get('doctrine')->getManager()->getRepository(Village::class);
    }

    protected function configure(): void
    {
        $this
            //->setDescription('Show recommendations for a film')
            ->addArgument('name', InputArgument::REQUIRED, 'Name of the village (spaces must be quoted)')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');

        $village = $this->villageRepository->findOneBy(
            ['name' => $name]);
        if(!$village) {
            $output->writeln('unknown village: ' . $name );
            exit(1);
        }
        $output->writeln($village . ':');

        foreach($village->getCards() as $card) {
            $output->writeln('-'. $card);
        }

        return Command::SUCCESS;
    }
}
