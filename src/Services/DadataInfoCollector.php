<?php

namespace App\Services;

use App\Contracts\CompanyInfoCollector\CompanyInfoCollector;
use App\Contracts\CompanyInfoCollector\CompanyInfoDTO;
use App\Contracts\CompanyInfoCollector\CompanyStatus;
use Dadata\DadataClient;
use GuzzleHttp\Exception\GuzzleException;

class DadataInfoCollector implements CompanyInfoCollector
{
    private DadataClient $client;

    public function __construct(
        private readonly string $key,
        private readonly string $secret
    )
    {
        $this->client = new DadataClient($this->key, $this->secret);
    }

    /**
     * @throws GuzzleException
     */
    public function collect(string|int $companyId): ?CompanyInfoDTO
    {
        $data = $this->client->findById('party', $companyId, 1);

        if (count($data) === 0) {
            return null;
        }

        $data = $data[0];
        $dto = new CompanyInfoDTO();

        $dto->name = $data['value'];
        $dto->okved = $data['data']['okved'];

        // Я не совсем понял, скорее всего имелся ввиду статус организации
        foreach (CompanyStatus::cases() as $case){
            if ($case->name === $data['data']['state']['status']) {
                $dto->activity = $case;
                break;
            }
        }

        return $dto;
    }
}
