<?php

namespace App\Command;

use App\Entity\Category;
use App\Form\CategoryAutocompleteField;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormFactoryInterface;

#[AsCommand(
    name: 'app:bug',
    description: 'Add a short description for your command',
)]
class BugCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $em,
        private FormFactoryInterface $factory
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // 1. ./bin/console d:sc:update --dump-sql
        // 2. ./bin/console d:q:sql 'INSERT INTO app.category (id, name) VALUES (1, "cat1")'
        // 3. ./bin/console d:q:sql 'INSERT INTO app.category (id, name) VALUES (2, "cat2")'
        // 4. ./bin/console d:q:sql 'INSERT INTO app.category (id, name) VALUES (3, "cat3")'
        // 5. ./bin/console app:bug
        // 6. we've loaded all entities with finaAll, later getEntitiesByIds will load them again because QB is bypassing UoW
        // this is okay on small set, but larger set...

        $category = $this->em->getRepository(Category::class)->findAll();

        $data = new \stdClass();
        $data->categories = [
            $category[0],
            $category[1],
        ];

        $builder = $this->factory->createBuilder(FormType::class, $data);
        $builder
            ->add('categories', CollectionType::class, [
                'entry_type' => CategoryAutocompleteField::class,
                'entry_options' => [
                    'label' => false,
                ],
            ])
        ;
        $builder->getForm();

        return Command::SUCCESS;
    }
}
