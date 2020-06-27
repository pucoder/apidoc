<?php
namespace Coder\Document\Middleware;

use Closure;

class DocumentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->path() === 'api-doc') {
            system(base_path('apidoc.sh'));
        }

        return $next($request);
    }
}
