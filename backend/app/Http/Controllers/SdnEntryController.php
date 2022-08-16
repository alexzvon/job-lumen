<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\LocksRW;
use App\Repositories\LocksRWRepository;
use App\Services\SdnEntryService;

use GuzzleHttp\Client;

class SdnEntryController extends Controller
{
  const URL_UPDATE_SDN_ENTRY = 'https://www.treasury.gov/ofac/downloads/sdn.xml';

  private $locksRWRepository;
  private $sdnEntryService;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->locksRWRepository = app(LocksRWRepository::class);
    $this->sdnEntryService = app(SdnEntryService::class);
  }

  /**
   * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
   */
  public function Update()
  {
    $result = ["result" => false, "info" => "service unavailable", "code" => 503];

    if (!$this->locksRWRepository->Check(LocksRW::SDN_UPDATE_LOCK)) {
      $client = new Client();
      $res = $client->get(self::URL_UPDATE_SDN_ENTRY);

      if (200 == $res->getStatusCode()) {
        $result = ["result" => true, "info" => "", "code" => 200];
      }
    }

    return response()->json($result);
  }

  /**
   * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
   */
  public function State()
  {
    return response()->json($this->sdnEntryService->State());
  }

  /**
   * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
   */
  public function GetNames(Request $request)
  {
    $type = $request->type ?? '';
    $name = $request->name ?? '';

    return response()->json($this->sdnEntryService->GetNames($name, $type));
  }
}
