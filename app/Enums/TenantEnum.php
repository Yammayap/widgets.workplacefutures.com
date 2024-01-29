<?php

namespace App\Enums;

use App\Enums\Contracts\HasLabel;
use Propaganistas\LaravelPhone\PhoneNumber;

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
            self::WFG        => 'Workplace Futures Group',
        };
    }

    /**
     * @return PhoneNumber|null
     */
    public function phone(): ?PhoneNumber
    {
        // copied from their websites
        return match ($this) {
            self::AMBIT      => new PhoneNumber('02031761777', 'GB'),
            self::MODUS      => new PhoneNumber('02078289009', 'GB'), // the general number
            self::PLATFFORM  => null, // TBC - no phone on their website
            self::TWO        => new PhoneNumber('02038978067', 'GB'),
            self::WFG        => new PhoneNumber('02079631801', 'GB'),
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
            self::WFG        => 'https://workplacefutures.com/', // www's redirect to this
        };
    }

    /**
     * @return string
     */
    private function logo(): string
    {
 // todo: These are just temp logos from their websites - they should be replaced later
        return match ($this) {
            self::AMBIT      => 'ambit.svg',
            self::MODUS      => 'modus.svg',
            self::PLATFFORM  => 'platfform.svg',
            self::TWO        => 'two.png',
            self::WFG        => 'wfg.svg',
        };
    }

    /**
     * @return string
     */
    public function logoFilepath(): string
    {
        return '/tenants/logos/' . $this->logo();
    }
}
