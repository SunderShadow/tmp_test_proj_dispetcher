<?php

namespace App\Contracts\CompanyInfoCollector;

enum CompanyStatus: string
{
    case ACTIVE = 'active';
    case LIQUIDATING = 'liquidating';
    case LIQUIDATED = 'liquidated';
    case BANKRUPT = 'bankruptcy';
    case REORGANIZING = 'reorganizationing';
}
