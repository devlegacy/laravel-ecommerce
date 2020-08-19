<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Storage;

class UploadImageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Closure                  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $file = $request->file('image');
        if ($file) {
            $path = $request->file('image')->store('products');
            $request->merge(['image' => Storage::url($path)]);
        }

        return $next($request);
    }
}
