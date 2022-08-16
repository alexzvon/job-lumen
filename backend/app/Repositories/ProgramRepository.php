<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\ProgramList as Model;

class ProgramRepository extends CoreSdnRepository
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

        if (isset($sdnEntry['uid']) && isset($sdnEntry['programList'])) {
            if (is_array($sdnEntry['programList']['program'])) {
                foreach ($sdnEntry['programList']['program'] as $v) {
                    $result[] = [
                        'uid_sdn_entry' => $sdnEntry['uid'],
                        'program' => $v
                    ];
                }
            } else {
                $result[] = [
                    'uid_sdn_entry' => $sdnEntry['uid'],
                    'program' => $sdnEntry['programList']['program']
                ];
            }
        }

        return $result;
    }

    public function Empty(array $sdnEntry): bool
    {
        return !app('db')->scalar('SELECT EXISTS (SELECT * FROM program_list WHERE uid_sdn_entry = ?);', [$sdnEntry['uid']]);
    }
}
