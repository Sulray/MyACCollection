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
    name: 'app:list-villages',
    description: 'Add a short description for your command',
)]
class ListVillagesCommand extends Command
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
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $villages = $this->villageRepository->findAll();
        if(!$villages) {
            $output->writeln('<comment>no villages found<comment>');
            exit(1);
        }

        foreach($villages as $village)
        {
            $output->writeln($village);
        }

        return Command::SUCCESS;
    }
}
