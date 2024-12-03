<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * ResponseCache Middleware
 *
 * This middleware caches the GET request responses for faster retrieval. It checks if a cached
 * version of the response already exists for the requested URL. If it does, it returns the cached response.
 * If not, it processes the request, stores the response in the cache, and then returns the response.
 */
class ResponseCache
{
    /**
     * Handle an incoming request.
     *
     * This method intercepts GET requests and checks if a cached response exists for the request.
     * If a cached response is found, it is returned directly. If not, the request is processed, and
     * the response is cached for future use.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the request is a GET request
        if ($request->isMethod('get')) {
            // Generate the cache key based on the full URL of the request
            $key = $this->getCacheKey($request);

            // If a cached response exists for the generated key, return it
            if (Cache::has($key)) {
                return response(Cache::get($key));
            }

            // Process the request to get the response
            $response = $next($request);

            // If the response is successful, cache its content for 10 minutes (600 seconds)
            if ($response->isSuccessful()) {
                Cache::put($key, $response->getContent(), 600);
            }
            
            // Return the processed response
            return $response;
        }

        // If the request is not a GET request, pass it through to the next middleware
        return $next($request);
    }

    /**
     * Generate a unique cache key for the given request.
     *
     * This method generates a cache key based on the full URL of the request.
     * The cache key is hashed to ensure uniqueness and efficiency.
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    protected function getCacheKey($request)
    {
        // Cache key is based on the MD5 hash of the full URL
        return 'response_cache:' . md5($request->fullUrl());
    }
}
