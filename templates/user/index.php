<article class="hreview open special">
	<?php if (empty($users)): ?>
		<div class="dhd">
			<h2 class="item title">Hoopla! Keine User gefunden.</h2>
		</div>
	<?php else: ?>
		<?php foreach ($users as $user): ?>
			<div class="panel panel-default">
				<div class="panel-heading"><?= $user->first_name; ?> <?= $user->last_name; ?></div>
				<div class="panel-body">
					<p class="description">In der Datenbank existiert ein User mit dem Namen <?= $user->first_name; ?> <?= $user->last_name; ?>. Dieser hat die EMail-Adresse: <a href="mailto:<?= $user->email; ?>"><?= $user->email; ?></a></p>
					<p>
						<a title="Löschen" href="/user/delete?id=<?= $user->id; ?>">Löschen</a>
					</p>
				</div>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
</article>
