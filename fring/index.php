<?php
require __DIR__ . '/members.php';
$ids = array_keys($members);
$at = array_search($_GET['id'] ?? '', $ids, true);
$go = $_GET['go'] ?? '';
$welcome = $_GET['welcome'] ?? '';
if (!isset($members[$welcome])) $welcome = '';

// redirector
if ($at !== false && ($go === 'prev' || $go === 'next')) {
	$count = count($ids);
	$to = ($at + ($go === 'next' ? 1 : $count - 1)) % $count;
	header('Cache-Control: no-store');	
	header('Location: ' . $members[$ids[$to]]['url'], true, 302);
	exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($title) ?></title>
<link rel="stylesheet" href="dir.css">
<h1><?= htmlspecialchars($title) ?></h1>

<!-- Header -->
<?php if (!empty($intro)): ?>
<div class="intro"><?= $intro ?></div>
<?php endif; ?>

<!-- Welcome -->
<?php if ($welcome):
	$base = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . '://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/';
	$id = rawurlencode($welcome);
	$embed = <<<HTML
<link rel="stylesheet" href="{$base}ring.css">
<nav class="ring" aria-label="Fring webring">
  <a class="prev" href="{$base}?id={$id}&amp;go=prev">
	<img src="{$base}img/arrow.svg" alt="Previous site">
  </a>
  <a class="dir" href="{$base}">
	<img src="{$base}img/dir.svg" alt="Directory">
  </a>
  <a class="next" href="{$base}?id={$id}&amp;go=next">
	<img src="{$base}img/arrow.svg" alt="Next site">
  </a>
</nav>
HTML;
?>
<section class="welcome">
	<h2>Welcome, <?= htmlspecialchars($members[$welcome]['name']) ?></h2>
	<p>Paste this anywhere on your page:</p>
	<textarea readonly rows="14"><?= htmlspecialchars($embed) ?></textarea>
	<?= $embed ?>
	<h3>Style options</h3>
	<ul class="options">
		<li><code>--ring-bg</code>: background colour (default <code>#fff</code>)</li>
		<li><code>--ring-border</code>: border, or <code>0</code> for none (default <code>1px solid #000</code>)</li>
		<li><code>--ring-height</code>: image height (default <code>40px</code>)</li>
		<li><code>--ring-pad</code>: inner padding (default <code>12px</code>)</li>
		<li><code>ring-full</code> class: stretches the embed to full width</li>
		<li><code>arrow-white.svg</code> and <code>dir-white.svg</code>: images for dark backgrounds</li>
		<li>Hover: <code>opacity: 1</code> clears the default fade, then add <code>scale</code>, <code>translate</code>, <code>rotate</code> or <code>filter</code></li>
		<li>Your own images: point any <code>&lt;img src&gt;</code> at your own file (arrows point right; the left one is mirrored)</li>
	</ul>
	<pre>&lt;style&gt;
.ring {
  --ring-bg: #000;
  --ring-border: 0;
  --ring-height: 32px;
  --ring-pad: 16px;
}
&lt;/style&gt;</pre>
</section>
<?php endif; ?>

<!-- Member List -->
<ul class="members">
	<?php foreach ($members as $id => $member): ?>
	<li>
		<a href="<?= htmlspecialchars($member['url']) ?>">
		<?php $icon = current(array_filter(["$id.png", "$id.jpg", "$id.jpeg"], fn($file) => is_file(__DIR__ . "/members/$file"))); ?>
			<?php if ($icon): ?>
			<img src="members/<?= rawurlencode($icon) ?>" width="128" height="128" alt="">
			<?php else: ?>
			<span class="no-icon"></span>
			<?php endif; ?>
			<?= htmlspecialchars($member['name']) ?>
		</a>
	</li>
	<?php endforeach; ?>
</ul>