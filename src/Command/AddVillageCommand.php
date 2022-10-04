<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;
use App\Entity\Village;

#[AsCommand(
    name: 'app:add-village',
    description: 'Add a short description for your command',
)]
class AddVillageCommand extends Command
{
    /**
     * @var EntityManager : gère les fonctions liées à la persistence
     */
    private $em;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->em = $container->get('doctrine')->getManager();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('name', InputArgument::REQUIRED, 'Argument description')
            ->addArgument('description', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $description = $input->getArgument('description');

        $village = new Village();
        $village->setName($name);

        // marque l'instance comme "à sauvegarder" en base
        $this->em->persist($village);

        // génère les requêtes en base
        $this->em->flush();

        return Command::SUCCESS;
    }
}
