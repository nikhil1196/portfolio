<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
class EnsurePermission
{
    public function handle(Request $request, Closure $next, string $perm)
    {
        $u = $request->user();
        if ($u && ($u->hasPerm('*') || $u->hasPerm($perm) || $request->isMethod('GET'))) {
            return $next($request);
        }
        abort(403, 'No permission for this module.');
    }
}
