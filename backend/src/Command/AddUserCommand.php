<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

/**
 * AddUser command.
 */
class AddUserCommand extends Command
{

    protected $inputs = [
        'email' => null,
        'password' => null,
        'name' => null,
    ];

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Users');
    }

    /**
     * Hook method for defining this command's option parser.
     *
     * @see https://book.cakephp.org/3.0/en/console-and-shells/commands.html#defining-arguments-and-options
     *
     * @param \Cake\Console\ConsoleOptionParser $parser The parser to be defined
     * @return \Cake\Console\ConsoleOptionParser The built parser.
     */
    public function buildOptionParser(ConsoleOptionParser $parser)
    {
        $parser = parent::buildOptionParser($parser);
        $parser->addOption('email', [
            'short' => 'e',
            'help' => 'Email'
        ]);
        $parser->addOption('name', [
            'short' => 'n',
            'help' => 'Name'
        ]);

        return $parser;
    }

    /**
     * Implement this method with your command's logic.
     *
     * @param \Cake\Console\Arguments $args The command arguments.
     * @param \Cake\Console\ConsoleIo $io The console io
     * @return null|int The exit code or null for success
     */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        foreach($this->inputs as $key => $val) {
            $this->inputs[$key] = $args->getOption($key);
        }

        $this->inputs['password'] = $io->ask('Please input password');

        $entity = $this->Users->newEntity($this->inputs);

        if ($entity->getErrors()) {
            $errors = $entity->getErrors();
            $io->error($this->arrayToJson($errors));
            $this->abort();
        }

        if (!$this->Users->save($entity)) {
            $errors = $entity->getErrors();
            $io->error($this->arrayToJson($errors));
            $this->abort();
        }

        $io->success('Created user successfully');
    }

    protected function arrayToJson(array $array)
    {
        return json_encode($array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
