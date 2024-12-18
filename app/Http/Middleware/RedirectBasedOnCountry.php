<?php

namespace App\Http\Middleware;

use Closure;
use GeoIp2\Database\Reader;
use Illuminate\Http\Request;

class RedirectBasedOnCountry
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Path to your GeoLite2-Country.mmdb file
        $databasePath = storage_path('app/GeoLite2-Country.mmdb');

        // Initialize GeoIP reader
        $reader = new Reader($databasePath);

        // Get user's IP address
        $ip = $request->ip();
       if($ip != '127.0.0.1'){

           try {
               // Attempt to retrieve user's country based on IP address
               $record = $reader->country($ip);
               $userCountry = $record->country->isoCode;

               // Default redirect URL
               $redirectUrl = env('url');



               // Define redirection URLs based on country
               if ($userCountry === 'EG') {
                   $redirectUrl = env('eg');
               }

               // Define redirection URLs based on country
               if ($userCountry === 'US') {
                   $redirectUrl = env('us');
               }

               // Parse the host from the redirect URL
               $redirectHost = parse_url($redirectUrl, PHP_URL_HOST);

               // Check if the current request's host matches the redirect URL's host
               if ($request->getHost() !== $redirectHost) {
                   // If the domains are different, redirect to the correct country-specific URL
                   return redirect()->away($redirectUrl);
               }
           } catch (\Exception $e) {
               // Handle exceptions (e.g., IP address not found), and redirect to the default site
               return redirect()->away('https://tendystuffshop.com/');
           }
       }


        // If the domain matches, allow the request to proceed
        return $next($request);
    }
}
