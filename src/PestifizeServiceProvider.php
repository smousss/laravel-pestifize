<?php

namespace Smousss\Laravel\Pestifize;

use Spatie\LaravelPackageTools\Package;
use Smousss\Laravel\Pestifize\Commands\PestifizeCommand;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class PestifizeServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package) : void
    {
        $package
            ->name('pestifize')
            ->hasConfigFile()
            ->hasCommand(PestifizeCommand::class);
    }
}
