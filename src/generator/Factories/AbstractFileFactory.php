<?php

declare(strict_types=1);

namespace Generator\Factories;

use Generator\AbstractCommand;
use Nette\PhpGenerator\PhpFile;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Kawa\Support\Str;

class AbstractFileFactory extends AbstractCommand
{

	/**
	 * Nette PHP File
	 *
	 * @var PhpFile
	 */
	protected PhpFile $file;

	/**
	 * Generated file name
	 *
	 * @var string|null
	 */
	protected ?string $filename = null;

	/**
	 * Generated file namespace
	 *
	 * @var string|null
	 */
	protected ?string $namespaceName = null;

	/**
	 * Php namespace object
	 *
	 * @var \Nette\PhpGenerator\PhpNamespace|null
	 */
	protected ?\Nette\PhpGenerator\PhpNamespace $namespace = null;

	/**
	 * Php class object
	 *
	 * @var \Nette\PhpGenerator\ClassType|null
	 */
	protected ?\Nette\PhpGenerator\ClassType $phpClass = null;

	/**
	 * Path to file
	 *
	 * @var string|null
	 */
	protected ?string $path = null;

	/**
	 * Initialize Symfony style interface
	 *
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 * @return void
	 */
	protected function initialize(InputInterface $input, OutputInterface $output) : void
    {
		parent::initialize($input, $output);

		$this->file = new PhpFile();
		$this->file->setStrictTypes();
    }

	/**
	 * Define main arguments
	 *
	 * @return void
	 */
	protected function defineArguments() : void
	{
		$name = Str::of($this->name)->studly();

		$namespaceName = count(explode('\\', $name->replace('/', '\\')->value())) > 1 ?
				$this->namespaceName . '\\' . $name->replace('/', '\\')->beforeLast('\\') :
				$this->namespaceName;

		$className = $name->replace('\\', '/')->afterLast('/')->value();
		$pathName = $name->replace('\\', '/');

		/**
		 * Define filename
		 */
		$this->filename = get_template_directory() . $this->path . $pathName . '.php';

		/**
		 * Define class object
		 */
		$this->namespace = $this->file->addNamespace($namespaceName);
		$this->phpClass = $this->namespace->addClass($className);
	}

	/**
	 * Extend default class
	 *
	 * @param string $class
	 * @return void
	 */
	protected function extendClass(string $class) : void
	{
		$this->phpClass->setExtends($class);
		$this->namespace->addUse($class);
	}

	/**
	 * Create method wth body
	 *
	 * @param string $name
	 * @param string $body
	 * @return \Nette\PhpGenerator\Method
	 */
	protected function createMethod(string $name, string $body = '//...') : \Nette\PhpGenerator\Method
	{
		$method = $this->phpClass->addMethod($name);
		$method->addBody($body);

		return $method;
	}

	/**
	 * Create file and return status
	 *
	 * @return integer
	 */
	protected function createFile() : int
	{
		$parts = explode('/', $this->filename);
        $file = array_pop($parts);
        $dir = '';
        foreach ($parts as $part) {
            if (!is_dir($dir .= "/$part")) {
				mkdir($dir, 0755);
			}
		}

		if (file_exists("$dir/$file")) {
			return static::FAILURE;
		}

		file_put_contents("$dir/$file", $this->file);

		return static::SUCCESS;
	}
}
