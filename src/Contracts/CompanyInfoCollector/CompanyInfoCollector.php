<?php

namespace App\Contracts\CompanyInfoCollector;

use GuzzleHttp\Exception\GuzzleException;

interface CompanyInfoCollector
{
    /**
     * @throws GuzzleException
     */
    public function collect(string|int $companyId): ?CompanyInfoDTO;
}
