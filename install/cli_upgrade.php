<?php
/**
 * CLI Upgrade helper to install/update optional extensions
 *
 * Usage:
 *   php install/cli_upgrade.php --extensions=blog,landpage,mooc
 *   (default installs all known extensions)
 */

// Base dirs
define('DIR_REAMUR', str_replace('\\', '/', realpath(__DIR__ . '/..')) . '/');
define('DIR_APPLICATION', DIR_REAMUR . 'install/');

$known = [
	'blog'     => DIR_APPLICATION . 'extensions/blog-extension.php',
	'landpage' => DIR_APPLICATION . 'extensions/landpage-extension.php',
	'mooc'     => DIR_APPLICATION . 'extensions/mooc-extension.php'
];

// Parse args
$extensionsArg = null;
foreach ($argv as $arg) {
	if (strpos($arg, '--extensions=') === 0) {
		$extensionsArg = substr($arg, strlen('--extensions='));
	}
}

if ($extensionsArg) {
	$list = array_filter(array_map('trim', explode(',', $extensionsArg)));
	$todo = [];
	foreach ($list as $item) {
		if (isset($known[$item])) {
			$todo[$item] = $known[$item];
		} else {
			echo "WARN: Unknown extension '{$item}', skipping.\n";
		}
	}
	if (!$todo) {
		echo "Nothing to install. Known: " . implode(',', array_keys($known)) . "\n";
		exit(1);
	}
} else {
	$todo = $known;
}

echo "Running extension upgrade for: " . implode(', ', array_keys($todo)) . "\n";

$php = PHP_BINARY ?: 'php';
$fails = [];

foreach ($todo as $code => $script) {
	if (!is_file($script)) {
		echo "ERROR: Script not found for {$code}: {$script}\n";
		$fails[] = $code;
		continue;
	}

	$cmd = escapeshellcmd($php) . ' ' . escapeshellarg($script);
	echo "==> {$code}\n";
	$exit = 0;
	passthru($cmd, $exit);
	if ($exit !== 0) {
		echo "FAILED ({$code}) exit={$exit}\n";
		$fails[] = $code;
	}
}

if ($fails) {
	echo "Completed with errors in: " . implode(', ', $fails) . "\n";
	exit(1);
}

echo "All requested extensions installed/updated successfully.\n";
exit(0);
