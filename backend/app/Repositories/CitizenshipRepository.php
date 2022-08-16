<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\CitizenshipList as Model;

class CitizenshipRepository extends CoreSdnRepository
{
  public function __construct()
  {
    parent::__construct();
  }

  protected function getModelClass(): string
  {
    return Model::class;
  }

  protected function parse(array $sdnEntry): array
  {
    $result = [];

    if (isset($sdnEntry['uid']) && isset($sdnEntry['citizenshipList'])) {
      if (isset($sdnEntry['citizenshipList']['citizenship']['uid'])) {
        $result[] = [
          'uid' => $sdnEntry['citizenshipList']['citizenship']['uid'] ?? null,
          'uid_sdn_entry' => $sdnEntry['uid'],
          'country' => $sdnEntry['citizenshipList']['citizenship']['country'] ?? null,
          'main_entry' => $sdnEntry['citizenshipList']['citizenship']['mainEntry'] ?? null,
        ];
      } else {
        foreach ($sdnEntry['citizenshipList']['citizenship'] as $citizenship) {
          $result[] = [
            'uid' => $citizenship['uid'] ?? null,
            'uid_sdn_entry' => $sdnEntry['uid'],
            'country' => $citizenship['country'] ?? null,
            'main_entry' => $citizenship['mainEntry'] ?? null,
          ];
        }
      }
    }

    return $result;
  }

  public function empty(array $sdnEntry): bool
  {
    return !app('db')->scalar('SELECT EXISTS (SELECT * FROM citizenship_list WHERE uid_sdn_entry = ?);', [$sdnEntry['uid']]);
  }
}
