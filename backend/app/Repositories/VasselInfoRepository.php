<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\VasselInfo as Model;

class VasselInfoRepository extends CoreSdnRepository
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

    if (isset($sdnEntry['uid']) && isset($sdnEntry['vesselInfo'])) {
      $result[] = [
        'uid_sdn_entry' => $sdnEntry['uid'],
        'call_sign' => $sdnEntry['vesselInfo']['callSign'] ?? null,
        'vessel_type' => $sdnEntry['vesselInfo']['vesselType'] ?? null,
        'vessel_flag' => $sdnEntry['vesselInfo']['vesselFlag'] ?? null,
        'vessel_owner' => $sdnEntry['vesselInfo']['vesselOwner'] ?? null,
        'gross_registered_tonnage' => $sdnEntry['vesselInfo']['grossRegisteredTonnage'] ?? null,
      ];
    }

    return $result;
  }

  public function empty(array $sdnEntry): bool
  {
    return !app('db')->scalar('SELECT EXISTS (SELECT * FROM vassel_info WHERE uid_sdn_entry = ?);', [$sdnEntry['uid']]);
  }
}
