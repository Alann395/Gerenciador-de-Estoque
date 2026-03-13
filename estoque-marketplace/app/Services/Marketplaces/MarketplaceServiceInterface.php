<?php

namespace App\Services\Marketplaces;

interface MarketplaceServiceInterface
{
    public function processarVenda(array $payload): array;

    public function processarCancelamento(array $payload): array;
}
