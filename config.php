<?php

if (!function_exists('envOrDefault')) {
    /**
     * Retrieve an environment variable with a default fallback when unset.
     */
    function envOrDefault(string $key, $default = null)
    {
        $value = getenv($key);

        return $value === false ? $default : $value;
    }
}

return [
    'sentry' => [
        'dsn' => envOrDefault('SENTRY_DSN', ''),
        // Defaults to a local environment when no explicit environment is provided.
        'environment' => envOrDefault('SENTRY_ENVIRONMENT', envOrDefault('APP_ENV', 'local')),
        // Release identifier; empty string keeps Sentry SDK defaults when not specified.
        'release' => envOrDefault('SENTRY_RELEASE', ''),
    ],
    'burst' => [
        // Number of events allowed before burst protection engages.
        'count' => (int) envOrDefault('FVM_BURST_COUNT', 12),
        // Time-to-live window (seconds) for burst protection counters.
        'ttl' => (int) envOrDefault('FVM_BURST_TTL', 60),
    ],
    'jetstream' => [
        // Maximum burst size for JetStream command processing (number of events).
        'burst' => (int) envOrDefault('FVM_JETSTREAM_BURST', 3),
        // Observation window for JetStream burst handling (seconds).
        'period' => (int) envOrDefault('FVM_JETSTREAM_PERIOD', 1),
    ],
];
