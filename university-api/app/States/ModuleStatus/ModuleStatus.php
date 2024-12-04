<?php
namespace App\States\ModuleStatus;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class ModuleStatus extends State
{
    abstract public function color(): string;

    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Draft::class)
            ->allowTransition(Draft::class, Published::class)
            ->allowTransition(Published::class, Draft::class);
    }
}
