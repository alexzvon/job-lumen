<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\DateOfBirthList as Model;

class DateOfBirthRepository extends CoreSdnRepository
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

    if (isset($sdnEntry['uid']) && isset($sdnEntry['dateOfBirthList'])) {
      if (isset($sdnEntry['dateOfBirthList']['dateOfBirthItem']['uid'])) {
        $result[] = [
          'uid' => $sdnEntry['dateOfBirthList']['dateOfBirthItem']['uid'] ?? null,
          'uid_sdn_entry' => $sdnEntry['uid'],
          'date_of_birth' => $sdnEntry['dateOfBirthList']['dateOfBirthItem']['dateOfBirth'] ?? null,
          'main_entry' => $sdnEntry['dateOfBirthList']['dateOfBirthItem']['mainEntry'] ?? null,
        ];
      } else {
        foreach ($sdnEntry['dateOfBirthList']['dateOfBirthItem'] as $dateOfBirthItem) {
          $result[] = [
            'uid' => $dateOfBirthItem['uid'] ?? null,
            'uid_sdn_entry' => $sdnEntry['uid'],
            'date_of_birth' => $dateOfBirthItem['dateOfBirth'] ?? null,
            'main_entry' => $dateOfBirthItem['mainEntry'] ?? null,
            ];
        }
      }
    }

    return $result;
  }

  public function empty(array $sdnEntry): bool
  {
    return !app('db')->scalar('SELECT EXISTS (SELECT * FROM date_of_birth_list WHERE uid_sdn_entry = ?);', [$sdnEntry['uid']]);
  }
}
