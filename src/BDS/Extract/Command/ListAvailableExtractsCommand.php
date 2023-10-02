<?php

declare(strict_types=1);

namespace D2L\DataHub\BDS\Extract\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;

#[AsCommand(name: 'extracts:list:available')]
class ListAvailableExtractsCommand extends ListExtractsCommand
{
    protected function configureSource(): static
    {
        ExtractCommandOptions::configAvailableDir($this, $this->options);
        return $this;
    }

    protected function configureDestination(): static
    {
        ExtractCommandOptions::configDownloadsDir($this, $this->options);
        return $this;
    }

    protected function getSource(InputInterface $input): array
    {
        return ExtractCommandOptions::getAvailableDir($input, $this->options);
    }

    protected function getDestination(InputInterface $input): array
    {
        return ExtractCommandOptions::getDownloadsDir($input, $this->options);
    }
}
