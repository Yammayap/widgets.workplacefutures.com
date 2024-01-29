<?php

namespace App\Enums;

use App\Enums\Contracts\HasLabel;

enum TenantEnum: string implements HasLabel
{
    case AMBIT = 'ambit';
    case MODUS = 'modus';
    case PLATFFORM = 'platfform';
    case TWO = 'two';
    case WFG = 'wfg';

    /**
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::AMBIT      => 'Ambit',
            self::MODUS      => 'Modus',
            self::PLATFFORM  => 'Platfform',
            self::TWO        => 'Two',
            default          => 'Workplace Futures Group',
        };
    }

    /**
     * @return string
     */
    public function phone(): string
    { // copied from their websites
        return match ($this) {
            self::AMBIT      => '02031761777',
            self::MODUS      => '02078289009', // the general number
            self::PLATFFORM  => 'N/A', // TBC - no phone on their website
            self::TWO        => '02038978067',
            default          => '02079631801', // wfg number
        };
    }

    /**
     * @return string
     */
    public function website(): string
    {
        return match ($this) {
            self::AMBIT      => 'https://www.ambitmoat.com/', // www's only
            self::MODUS      => 'https://www.modus.space/', // needs www's to work
            self::PLATFFORM  => 'https://www.platfform.uk/', // works with both
            self::TWO        => 'https://wearetwo.com/', // www's redirect back to this
            default          => 'https://workplacefutures.com/', // www's redirect to this
        };
    }

    /**
     * @return string
     */
    public function logo(): string
    { // todo: These are just temp logos from their websites - they should be replaced later
        return match ($this) {
            self::AMBIT      => 'ambit.svg',
            self::MODUS      => 'modus.svg',
            self::PLATFFORM  => 'platfform.svg',
            self::TWO        => 'two.png',
            default          => 'wfg.svg',
        }; // todo: get these via a tenant logo function - only reference file names here
    }
}
