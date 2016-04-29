<?php

namespace Myexp\Bundle\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Yaml\Yaml;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\Connection;

/**
 * 加载seed数据
 */
class LoadSeedCommand extends ContainerAwareCommand {

    /**
     * @var ObjectManager
     */
    private $entityManager;

    /**
     *
     * @var Connection 
     */
    private $connection;

    /**
     * {@inheritdoc}
     */
    protected function configure() {
        $this
                // a good practice is to use the 'app:' prefix to group all your custom application commands
                ->setName('k-cms:load-seed')
                ->setDescription('Load seed data and stores them in the database')
                ->setHelp($this->getCommandHelp())
                // commands can optionally define arguments and/or options (mandatory and optional)
                // see http://symfony.com/doc/current/components/console/console_arguments.html
                ->addArgument('entity', InputArgument::OPTIONAL, 'The entity for load')
                ->addOption('all', null, InputOption::VALUE_NONE, 'If set, will load all seed')
        ;
    }

    /**
     * This method is executed before the interact() and the execute() methods.
     * It's main purpose is to initialize the variables used in the rest of the
     * command methods.
     *
     * Beware that the input options and arguments are validated after executing
     * the interact() method, so you can't blindly trust their values in this method.
     */
    protected function initialize(InputInterface $input, OutputInterface $output) {
        $this->entityManager = $this->getContainer()->get('doctrine')->getManager();
        $this->connection = $this->getContainer()->get('doctrine.dbal.default_connection');
    }

    /**
     * This method is executed after initialize() and before execute(). Its purpose
     * is to check if some of the options/arguments are missing and interactively
     * ask the user for those values.
     *
     * This method is completely optional. If you are developing an internal console
     * command, you probably should not implement this method because it requires
     * quite a lot of work. However, if the command is meant to be used by external
     * users, this method is a nice way to fall back and prevent errors.
     */
    protected function interact(InputInterface $input, OutputInterface $output) {
        if (null !== $input->getArgument('entity') || null !== $input->getOption('all')) {
            return;
        }

        // multi-line messages can be displayed this way...
        $output->writeln('');
        $output->writeln('Load-Seed Command Interactive Wizard');
        $output->writeln('-----------------------------------');

        // ...but you can also pass an array of strings to the writeln() method
        $output->writeln(array(
            '',
            'If you prefer to not use this interactive wizard, provide the',
            'arguments required by this command as follows:',
            '',
            ' $ php app/console k-cms:load-seed entity',
            '',
        ));
    }

    /**
     * This method is executed after interact() and initialize(). It usually
     * contains the logic to execute to complete this command task.
     */
    protected function execute(InputInterface $input, OutputInterface $output) {

        $startTime = microtime(true);
        $entityPrefix = 'MyexpAdminBundle:';

        $entity = $input->getArgument('entity');
        $all = $input->getOption('all');

        $configDirectories = array(__DIR__ . '/../Resources/config');
        $locator = new FileLocator($configDirectories);
        $yamlSeedFiles = $locator->locate('seed.yml', null, false);

        $totalProcessed = 0;

        foreach ($yamlSeedFiles as $yamlSeedFile) {
            $entities = Yaml::parse(file_get_contents($yamlSeedFile));

            foreach ($entities as $entityName => $values) {

                if ($entity && $entityName != $entity) {
                    continue;
                }

                if (!$entity && !$all) {
                    continue;
                }

                $classMetaData = $this->entityManager->getClassMetadata($entityPrefix . $entityName);

                $tableName = $classMetaData->table['name'];
                $columnNames = $classMetaData->columnNames;
                $assocMaps = $classMetaData->associationMappings;

                foreach ($values as $value) {

                    $action = 'insert';

                    if (key_exists('id', $value)) {
                        $oldValue = $this
                                ->entityManager
                                ->getRepository($entityPrefix . $entityName)
                                ->find($value['id'])
                        ;
                    }

                    //处理value的关联object
                    $newValues = array();
                    foreach ($value as $k => $v) {
                        
                        if(is_bool($v)){
                            $v = intval($v);
                        }
                        
                        if (!key_exists($k, $columnNames) && key_exists($k, $assocMaps)) {
                            $newK = $assocMaps[$k]['joinColumns'][0]['name'];
                            $newValues[$newK] = $v;
                        } else {
                            $newValues[$columnNames[$k]] = $v;
                        }
                    }

                    $qb = $this->connection->createQueryBuilder();

                    //update
                    if ($oldValue) {
                        $action = 'update';
                        $qb->update($tableName, 't');
                        foreach ($newValues as $k => $v) {
                            if ('id' === $k) {
                                continue;
                            }
                            $qb
                                    ->set('t.' . $k, ":$k")
                                    ->setParameter($k, $v)
                            ;
                        }
                        $qb->where('t.id = ' . $value['id']);
                    } else {
                        //insert
                        $qb->insert($tableName);
                        foreach ($newValues as $k => $v) {
                            $qb
                                    ->setValue($k, ":$k")
                                    ->setParameter($k, $v)
                            ;
                        }
                    }

                    $qb->execute();

                    $output->writeln('');
                    $output->writeln(sprintf('[OK] %s a record.', $action));

                    $totalProcessed++;
                }
            }
        }

        if ($output->isVerbose()) {
            $finishTime = microtime(true);
            $elapsedTime = $finishTime - $startTime;

            $output->writeln(sprintf('[INFO] %d seed data has been loaded into database / Elapsed time: %.2f ms', $totalProcessed, $elapsedTime * 1000));
        }
    }

    /**
     * The command help is usually included in the configure() method, but when
     * it's too long, it's better to define a separate method to maintain the
     * code readability.
     */
    private function getCommandHelp() {
        return <<<HELP
The <info>%command.name%</info> command load seed data and saves them in the database:

  <info>php %command.full_name%</info> <comment>entity</comment>

By default the command load special entity. To load all entity data,
add the <comment>--all</comment> option:

  <info>php %command.full_name%</info> <comment>--all</comment>
HELP;
    }

}
