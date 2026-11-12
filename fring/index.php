<?php
require __DIR__ . '/members.php';
$ids = array_keys($members);
$at = array_search($_GET['id'] ?? '', $ids, true);
$go = $_GET['go'] ?? '';

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
<?php if (!empty($intro)): ?>
<div class="intro"><?= $intro ?></div>
<?php endif; ?>
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