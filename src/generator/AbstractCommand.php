<?php

declare(strict_types=1);

namespace Generator;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AbstractCommand extends Command
{
    /**
	 * Symfony Style
	 *
	 * @var SymfonyStyle
	 */
	protected SymfonyStyle $io;

	/**
	 * Initialize Symfony style interface
	 *
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 * @return void
	 */
	protected function initialize(InputInterface $input, OutputInterface $output) : void
    {
		$this->io = new SymfonyStyle($input, $output);
    }
}
