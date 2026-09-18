<?php require_once __DIR__ . '/config.php'; $menuUrl = 'assets/images/menu.jpg?v=' . @filemtime(MENU_IMAGE); ?><!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Full Menu | Plate & Pixel</title><link rel="stylesheet" href="assets/css/app.css"></head><body><header class="shell topbar"><a class="brand" href="index.php"><span class="brand-mark">✦</span><span>PLATE & PIXEL</span></a><nav class="nav"><a href="menu.php">Menu</a><a href="ar.php">AR scanner</a><a href="compile.php">Operator</a></nav></header><main class="shell"><div class="page-head"><div><div class="eyebrow">The complete spread</div><h1>Tonight's menu</h1></div><a class="btn alt" href="ar.php">Scan in AR</a></div><div class="menu-frame"><img src="<?= htmlspecialchars($menuUrl, ENT_QUOTES) ?>" alt="Complete Plate & Pixel food menu"></div></main><script>
(async function watchMenuUpdates() {
	let version = 0;
	try {
		const response = await fetch('api/target.php?ts=' + Date.now(), { cache: 'no-store' });
		const target = await response.json();
		version = target.version || 0;
	} catch (error) {
		return;
	}
	setInterval(async () => {
		try {
			const response = await fetch('api/target.php?ts=' + Date.now(), { cache: 'no-store' });
			const target = await response.json();
			if (version && target.version && target.version !== version) window.location.reload();
		} catch (error) {
			// Retry on the next poll if the API is temporarily unavailable.
		}
	}, 3000);
})();
</script></body></html>
