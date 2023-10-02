<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;

#[AsCommand(name: 'extracts:list:processed')]
class ListProcessedExtractsCommand extends ListExtractsCommand
{
    protected function configureSource(): static
    {
        ExtractCommandOptions::configProcessDir($this, $this->options);
        return $this;
    }

    protected function configureDestination(): static
    {
        ExtractCommandOptions::configUploadsDir($this, $this->options);
        return $this;
    }

    protected function getSource(InputInterface $input): array
    {
        return ExtractCommandOptions::getProcessDir($input, $this->options);
    }

    protected function getDestination(InputInterface $input): array
    {
        return ExtractCommandOptions::getUploadsDir($input, $this->options);
    }
}
