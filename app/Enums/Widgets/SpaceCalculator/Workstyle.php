<?php

namespace App\Enums\Widgets\SpaceCalculator;

enum Workstyle: string
{
    case SERVICE_DELIVERY = 'service-delivery';
    case CREATIVE = 'creative';
    case FINANCIAL = 'financial';
    case GENERAL = 'general';
    case TECHNOLOGY = 'technology';
    case LAW = 'law';
    case PROCESS_DRIVEN = 'process_driven';
    case PUBLIC_SECTOR = 'public_sector';

    /**
     * @return string
     */
    public function answerLabel(): string
    {
        return match ($this) {
            self::SERVICE_DELIVERY => 'Companies delivering services such as accounting and consultancy',
            self::CREATIVE => 'Creative industries such as advertising and architecture',
            self::FINANCIAL => 'Financial businesses such as investment funds and banks',
            self::GENERAL => 'General, multi-departmental businesses',
            self::TECHNOLOGY => 'IT and other technology dominant businesses',
            self::LAW => 'Law firms or similar knowledge working organisations',
            self::PROCESS_DRIVEN => 'Process driven businesses including call centres',
            self::PUBLIC_SECTOR => 'Public sector organisations or large back-offices',
        };
    }
}
