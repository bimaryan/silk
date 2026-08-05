<?php
$dir = new RecursiveDirectoryIterator('e:/silk/resources/views');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/^.+\.blade\.php$/i', RecursiveRegexIterator::GET_MATCH);

foreach($files as $file) {
    $path = $file[0];
    $content = file_get_contents($path);
    $replaced = $content;

    // Pattern 1: {{ asset('storage/' . $var->foto) ?? 'default' }}
    // Or without ?? 'default'
    $replaced = preg_replace_callback(
        '/\{\{\s*asset\([\'"](?:storage\/)?[\'"]\s*\.\s*(\$[a-zA-Z0-9_\->]+foto)\)\s*(?:\?\?\s*([\'"][^\'"]+[\'"]))?\s*\}\}/',
        function($matches) {
            $var = $matches[1];
            $default = isset($matches[2]) && $matches[2] ? "asset(" . $matches[2] . ")" : "''";
            return "{{ \\Illuminate\\Support\\Str::startsWith($var, ['http://', 'https://']) ? $var : ($var ? asset('storage/' . $var) : $default) }}";
        },
        $replaced
    );

    // Pattern 2: {{ asset('storage/' . $var->foto) }} (handled above if no ??)

    // Pattern 3: {{ asset($var->foto ?? 'default') }}
    $replaced = preg_replace_callback(
        '/\{\{\s*asset\(\s*(\$[a-zA-Z0-9_\->]+foto)\s*\?\?\s*([\'"][^\'"]+[\'"])\s*\)\s*\}\}/',
        function($matches) {
            $var = $matches[1];
            $default = isset($matches[2]) ? "asset(" . $matches[2] . ")" : "''";
            // if it's asset($data->foto) it means they forgot storage/ or foto already includes it. We'll add storage/ just in case, but actually if they used asset($data->foto ?? 'image/x') they probably wanted storage/.
            // Wait, for ruangan, they did asset($data->foto). Let's use storage/ if not http.
            return "{{ \\Illuminate\\Support\\Str::startsWith($var, ['http://', 'https://']) ? $var : ($var ? asset('storage/' . $var) : $default) }}";
        },
        $replaced
    );
    
    // Pattern 4: {{ asset(('storage/' . $var->foto) ?? 'default') }} (noticed this in modaldetailDosen)
    $replaced = preg_replace_callback(
        '/\{\{\s*asset\(\(\s*[\'"](?:storage\/)?[\'"]\s*\.\s*(\$[a-zA-Z0-9_\->]+foto)\s*\)\s*\?\?\s*([\'"][^\'"]+[\'"])\s*\)\s*\}\}/',
        function($matches) {
            $var = $matches[1];
            $default = isset($matches[2]) ? "asset(" . $matches[2] . ")" : "''";
            return "{{ \\Illuminate\\Support\\Str::startsWith($var, ['http://', 'https://']) ? $var : ($var ? asset('storage/' . $var) : $default) }}";
        },
        $replaced
    );

    if ($replaced !== $content) {
        file_put_contents($path, $replaced);
        echo "Updated $path\n";
    }
}
