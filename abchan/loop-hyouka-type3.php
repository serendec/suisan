<?php
list($post_keys) = $args;
if(isset($post_keys[get_the_ID()])):
?>
<tbody>

	<?php
	//meta_keyをもとに直接目的の行のデータを取得
	$data_key = $post_keys[get_the_ID()].'_データ';
	$repeaters = get_field($data_key);
	?>

	<?php ob_start(); //魚種の表示 ?>
	<td rowspan="<?php echo count($repeaters); ?>">
		<div class="p-fish-species">
			<div class="p-name"><?php the_title() ?></div>
			<?php if (has_post_thumbnail($post->ID)) : ?>
				<div class="p-image" style="background-image: url(<?php echo get_the_post_thumbnail_url($post->ID, 'full'); ?>)"></div>
			<?php else : ?>
				<div class="p-image" style="background-image: url(<?php _e_asset_url('img/no-image.png'); ?>);"></div>
			<?php endif; ?>
		</div>
	</td>
	<?php $header = ob_get_clean(); ?>

	<?php
	foreach($repeaters as $repeater):
	?>
	<tr>
		<?php echo $header; ?>
		<td><?php echo $repeater['ブロック']; ?></td>
		<td>
			<ul class="p-dl-btn-list">
				<?php foreach($repeater['資料'] as $doc): ?>
				<li>
					<a href="<?php echo $doc['ファイル']['url'] ?>" class="p-dl-btn" target="_blank">
					<i class="fal fa-file-pdf"></i>
					<?php if($doc['資料名'] === 'その他資料名'): ?>
						<?php echo $doc['その他資料名'] ?>
					<?php else : ?>
						<?php echo $doc['資料名'] ?>
					<?php endif; ?>
					<span><?php
						$filesize = $doc['ファイル']['filesize'] / (1024 * 1024);
						echo number_format($filesize, 1);
					?>MB</span>
					</a>
				</li>
				 <?php endforeach; ?>
			</ul>
		</td>
	</tr>
	<?php
		$header = '';//最初以外は魚種の表示をしないため空にする
	endforeach;
	?>
</tbody>
<?php endif; ?>