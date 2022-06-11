<?php

declare(strict_types=1);

namespace Generator\Factories;

use Closure;
use Kawa\Foundation\Request;
use Kawa\Routing\Middleware;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MiddlewareFactory extends AbstractFileFactory
{
	/**
	 * Command name
	 *
	 * @var string
	 */
	protected static $defaultName = 'new:middleware';

	/**
	 * Controller name
	 *
	 * @var string|null
	 */
	protected ?string $name = null;

	/**
	 * Class namespace
	 *
	 * @var string|null
	 */
	protected ?string $namespaceName = 'Theme\\Http\\Middleware';

	/**
	 * Class path
	 *
	 * @var string|null
	 */
	protected ?string $path = '/src/Http/Middleware/';

	/**
	 * {@inheritDoc}
	 */
	protected function configure() : void
	{
		$this->addArgument('name', InputArgument::REQUIRED, 'Middleware name');
	}

	/**
	 * {@inheritDoc}
	 */
	protected function execute(InputInterface $input, OutputInterface $output) : int
	{
		$this->name = $input->getArgument('name');

		$this->defineArguments();

		$this->extendClass(Middleware::class);

		$this->createMiddlewareMethod(
			'handle',
			<<<HANDLE
				//...
			return \$next(\$request);
			HANDLE
		);

		$status = $this->createFile();
		match ($status) {
			0 => $this->io->success(sprintf('Middleware %s was created!', $this->name)),
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
	private function createMiddlewareMethod(string $name, string $body = '//...') : \Nette\PhpGenerator\Method
	{
		$handle = $this->createMethod($name, $body);

		$request = $handle->addParameter('request');
		$request->setType(Request::class);
		$this->namespace->addUse(Request::class);

		$next = $handle->addParameter('next');
		$next->setType(Closure::class);
		$this->namespace->addUse(Closure::class);

		return $handle;
	}
}
