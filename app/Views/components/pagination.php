<?php if ($pageCount > 1): ?>
	<div class="mt-4 flex flex-col sm:flex-row justify-between items-center gap-3">
		<div class="text-sm text-gray-600">
			<?= "Showing page " . $currentPage . " of " . $pageCount . " (" . $totalCount . " total " . $tableLabel . ")"; ?>
		</div>
		<div class="flex gap-2">
			<?php
				// build query string from filters
				$queryParams = [];
				foreach ($filters as $key => $value) {
					if (!empty($value)) $queryParams[$key] = $value;
				}
				$queryString = http_build_query($queryParams); // url encode
				$paginationBaseUrl = $_SERVER['REQUEST_URI'] . "?" . ($queryString ? $queryString . "&" : "");
			?>

			<?php if ($currentPage > 1): ?>
				<a href="<?= $paginationBaseUrl ?>page=1" class="px-3 py-1 text-sm border border-gray-300 rounded bg-white hover:bg-gray-100 transition-colors">First</a>
				<a href="<?= $paginationBaseUrl ?>page=<?= $currentPage - 1 ?>" class="px-3 py-1 text-sm border border-gray-300 rounded bg-white hover:bg-gray-100 transition-colors">Previous</a>
			<?php endif; ?>

			<?php
				$previousPage = max(1, $currentPage - 1);
				$nextPage = min($pageCount, $currentPage + 1);

				for ($i = $previousPage; $i <= $nextPage; $i++):
			?>
				<?php if ($i == $currentPage): ?>
					<span class="px-3 py-1 text-sm border border-blue-500 rounded bg-blue-500 text-white font-semibold"><?= $i ?></span>
				<?php else: ?>
					<a href="<?= $paginationBaseUrl ?>page=<?= $i ?>" class="px-3 py-1 text-sm border border-gray-300 rounded bg-white hover:bg-gray-100 transition-colors"><?= $i ?></a>
				<?php endif; ?>
			<?php endfor; ?>

			<?php if ($currentPage < $pageCount): ?>
				<a href="<?= $paginationBaseUrl ?>page=<?= $currentPage + 1 ?>" class="px-3 py-1 text-sm border border-gray-300 rounded bg-white hover:bg-gray-100 transition-colors">Next</a>
				<a href="<?= $paginationBaseUrl ?>page=<?= $pageCount ?>" class="px-3 py-1 text-sm border border-gray-300 rounded bg-white hover:bg-gray-100 transition-colors">Last</a>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>
