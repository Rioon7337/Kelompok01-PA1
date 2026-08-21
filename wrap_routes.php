<?php
$content = file_get_contents("routes/web.php");

// Find the start of the routes (after the use statements)
$pattern = "/(\/\/ ========================================\s*\n\/\/ ========== FRONTEND ROUTES \(PUBLIC\) ==========\s*\n\/\/ ========================================\s*\n)/i";

$parts = preg_split($pattern, $content, 2, PREG_SPLIT_DELIM_CAPTURE);

if (count($parts) === 3) {
    $header = $parts[0];
    $comment = $parts[1];
    $routes = $parts[2];
    
    // Add the middleware wrap
    $newRoutes = "Route::middleware([\App\Http\Middleware\LanguageMiddleware::class])->group(function () {\n\n" . $comment . $routes . "\n});\n";
    
    file_put_contents("routes/web.php", $header . $newRoutes);
    echo "Wrapped web.php successfully!";
} else {
    echo "Could not parse web.php";
}

