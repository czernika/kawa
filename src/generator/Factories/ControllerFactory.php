<?php

declare(strict_types=1);

namespace Generator\Factories;

use Kawa\Foundation\Request;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Theme\Http\Controllers\Controller;

class ControllerFactory extends AbstractFileFactory
{
	/**
	 * Command name
	 *
	 * @var string
	 */
	protected static $defaultName = 'new:controller';

	/**
	 * Controller name
	 *
	 * @var string|null
	 */
	protected ?string $name = null;

	/**
	 * Create constructor method or not
	 *
	 * @var boolean
	 */
	protected bool $constructor = false;

	/**
	 * Create invoke method or not
	 *
	 * @var boolean
	 */
	protected bool $invoke = false;

	/**
	 * Class namespace
	 *
	 * @var string|null
	 */
	protected ?string $namespaceName = 'Theme\\Http\\Controllers';

	/**
	 * Class path
	 *
	 * @var string|null
	 */
	protected ?string $path = '/src/Http/Controllers/';

	/**
	 * {@inheritDoc}
	 */
	protected function configure() : void
	{
		$this->addArgument('name', InputArgument::REQUIRED, 'Controller name');
		$this->addOption('constructor', 'c', InputOption::VALUE_NONE, 'Create constructor');
		$this->addOption('invokable', 'i', InputOption::VALUE_NONE, 'Create invokable instance');
	}

	/**
	 * {@inheritDoc}
	 */
	protected function execute(InputInterface $input, OutputInterface $output) : int
	{
		$this->name = $input->getArgument('name');
		$this->constructor = $input->getOption('constructor');
		$this->invoke = $input->getOption('invokable');

		$this->defineArguments();

		$this->extendClass(Controller::class);

		if ($this->constructor) {
			$this->createMethod('__construct');
		}

		$index = $this->invoke ? '__invoke' : 'index';
		$this->createControllerMethod($index);

		$status = $this->createFile();
		match ($status) {
			0 => $this->io->success(sprintf('Controller %s was created!', $this->name)),
			1 => $this->io->warning(sprintf('File %s already exists', $this->name)),
			default => $this->io->info('Processed'),
		};

		return static::SUCCESS;
	}

	/**
	 * Create specific controller method
	 *
	 * @param string $name
	 * @param string $body
	 * @return \Nette\PhpGenerator\Method
	 */
	private function createControllerMethod(string $name, string $body = '//...') : \Nette\PhpGenerator\Method
	{
		$index = $this->createMethod($name, <<<CONTROLLER
			$body
		CONTROLLER);
		$parameter = $index->addParameter('request');
		$parameter->setType(Request::class);
		$this->namespace->addUse(Request::class);

		return $index;
	}
}
