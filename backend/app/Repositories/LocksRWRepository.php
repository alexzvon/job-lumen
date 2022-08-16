<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\LocksRW as Model;

class LocksRWRepository extends CoreRepository
{
  public function __construct()
  {
    parent::__construct();
  }

  protected function getModelClass(): string
  {
    return Model::class;
  }

  /**
   * Установить
   * @param int $uid
   * @return bool
   */
  public function Lock(int $uid): bool
  {
    $result = false;

    if ($this->Check($uid)) {
      return $result;
    }

    try {
      app('db')->beginTransaction();

      $this->startConditions()->create(['uid' => $uid]);

      app('db')->commit();

      $result = true;
    } catch (\Exception $exception) {
      app('db')->rollback();
      app('log')->debug($exception);
    }

    return $result;
  }

  /**
   * Проверить
   * @param int $uid
   * @return bool
   */
  public function Check(int $uid): bool
  {
    return app('db')->scalar('SELECT EXISTS (SELECT uid FROM locks_r_w WHERE uid = ?);', [$uid]);
  }

  /**
   * Снять
   * @param int $uid
   * @return bool
   */
  public function UnLock(int $uid): bool
  {
    $result = false;

    if (!$this->Check($uid)) {
      return $result;
    }

    try {
      app('db')->beginTransaction();

      $this->startConditions()->destroy($uid);

      app('db')->commit();

      $result = true;
    } catch (\Exception $exception) {
      app('db')->rollback();
      app('log')->debug($exception);
    }

    return $result;
  }
}
