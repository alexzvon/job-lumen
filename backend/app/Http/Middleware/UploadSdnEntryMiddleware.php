<?php

namespace App\Http\Middleware;

use Closure;

use App\Services\SdnEntryService;

class UploadSdnEntryMiddleware
{
  const URL_UPDATE_SDN_ENTRY = 'https://www.treasury.gov/ofac/downloads/sdn.xml';

  private $sdnEntryService;

  public function __construct()
  {
    $this->sdnEntryService = app(SdnEntryService::class);
  }

  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    return $next($request);
  }

  /**
   * @param  \Illuminate\Http\Request  $request
   * @param  \Illuminate\Http\Response  $response
   * @return void
   */
  public function terminate($request, $response)
  {
    if ('GET' === $request->method() && 'update' === $request->path()) {
      $content = json_decode($response->getContent());  

      if ($content->result && 200 == $content->code ) {
        app('log')->info('Start update SdnEntry');

        if($this->sdnEntryService->Update(self::URL_UPDATE_SDN_ENTRY)) {
          app('log')->info('Update SdnEntry success');
        } else {
          app('log')->debug('Update SdnEntry fail');
        }
      }
    }
  }
}
