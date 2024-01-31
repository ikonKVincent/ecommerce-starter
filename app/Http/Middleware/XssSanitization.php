<?php

namespace App\Http\Middleware;

use Closure;
use GrahamCampbell\Security\Facades\Security;

final class XssSanitization
{
    public function handle($request, Closure $next)
    {
        if (auth()->guard('admin')) {
            return $next($request);
        }
        $crud_no_sanitise = crud_no_sanitise();
        $result = $this->sanitize($request->all(), $request, $crud_no_sanitise);
        $request->merge($result);

        return $next($request);
    }

    /**
     * Sanitise all request except files in crud_no_sanitise function
     * @param mixed $input
     * @param mixed $request
     * @param mixed $crud_no_sanitise
     *
     * @return array
     */
    private function sanitize($input, $request, $crud_no_sanitise): array
    {
        $result = [];
        if (!empty($input)) {
            foreach ($input as $key => $value) {
                $key = (is_int($key) || is_numeric($key)) ? $key : Security::clean($key);
                if (!$request->file($key)) {
                    if (is_array($value)) {
                        $result[$key] = $this->sanitize($value, $request, $crud_no_sanitise);
                    } else {
                        if (is_int($value) || is_numeric($value) || is_bool($value) || empty($value)) {
                            $result[$key] = $value;
                        } else {
                            if (in_array($key, $crud_no_sanitise)) {
                                $result[$key] = $value;
                            } else {
                                $result[$key] = $value ? Security::clean($value) : null;
                            }
                        }
                    }
                }
            }
        }

        return $result;
    }
}
