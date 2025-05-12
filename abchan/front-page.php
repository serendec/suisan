<?php get_header(); ?>
<main class="l-main">


	<section class="p-mainvisual">
		<div class="container">
			<div class="p-image">
				<img src="<?php _e_asset_url('img/img_mv1.png'); ?>" alt="わが国周辺の水産資源の現状を知るために">
			</div>
			<div class="p-text">
				<h2 class="p-title">わが国周辺の<br class="d-none d-md-block">水産資源の<br class="d-block d-md-none">現状を知るために</h2>
				<p>このサイトでは、我が国周辺漁業資源について、水産庁の委託を受け研究・教育機構が行っている調査の取組みや資源の状況等を紹介しています。</p>
			</div>
		</div>
	</section>


	<section class="p-home-about">
		<div class="container">
			<div class="p-text">
				<h3 class="p-title">水産資源評価とは</h3>
				<p>水産資源の管理に関する施策を効果的に推進していくためには、その対象となる水産資源の現状を知る必要があります。</p>
				<p>そのため、水産庁では国立研究開発法人水産研究・教育機構に委託して、我が国周辺水域の重要魚種の資源評価や、漁海況予報を実施しており、このホームページはそれらの取組や成果について紹介しているものです。</p>
				<a href="<?php echo esc_url(home_url('/')); ?>about/" class="p-button p-button--arrow">詳しく見る</a>
			</div>
			<div class="p-image">
				<img src="<?php _e_asset_url('img/img_home_about.webp'); ?>" alt="水産資源評価とは">
			</div>
		</div>

	</section>

	<section class="p-news-section">
		<div class="container">
			<div class="row">
				<div class="col-md-2">
					<h3 class="p-news-section__title"><span>News</span>更新情報</h3>
				</div>

				<div class="col-md-10">
					<div class="p-tab-panel">
						<ul class="p-tab-panel__tab">
							<li class="js-tab is-active js-waves">すべて</li>
							<li class="js-tab js-waves">水産資源評価結果</li>
							<li class="js-tab js-waves">漁海況予報</li>
						</ul>
						<div class="p-tab-panel__group">


							<div class="js-panel p-tab-panel__item is-active">
								<ul>
									<?php
										$args = array(
											'post_type' => 'update',
											// 'update-cat' => array('hoyka','gk'),
											'posts_per_page' => 3,
										);
										$my_posts = get_posts( $args );
										if ( $my_posts ) {
											foreach ( $my_posts as $post ) :
												setup_postdata( $post );
												?>
												<li class="p-item">
													<a href="<?php if(get_field('リンク')):?><?php the_field('リンク'); ?><?php else : ?><?php the_permalink(); ?><?php endif;?>" <?php if(get_field('別ウィンドウで開く')):?> target="_blank"<?php endif;?>>

														<div class="p-item__meta">
															<div class="p-item__date"><?php the_time('Y.m.d') ?></div>

															<?php if ($terms = get_the_terms($post->ID, 'update-cat')): ?>
															<ul class="c-label-list">
																<?php foreach ( $terms as $term ): ?>
																<li class="c-label<?php if( $term->name === '漁海況予報'){ echo ' c-label--theme-light';} ?>"><span class="main"><?php echo $term->name; ?></span></li>
																<?php endforeach; ?>
															</ul>
															<?php endif; ?>
														</div>
														<div class="p-item__title">
															<?php the_title(); ?>

															<?php if(get_field('別ウィンドウで開く')):?><i class="far fa-external-link-alt"></i><?php endif; ?>

														</div>
													</a>
												</li>

												<?php
											endforeach;
										} else {
											echo '登録がありません';
										}
										wp_reset_postdata();
									?>
								</ul>
							</div>


							<div class="js-panel p-tab-panel__item">
								<ul>
									<?php
										$args = array(
											'post_type' => 'update',
											'update-cat' => 'hyouka',
											'posts_per_page' => 3,
										);
										$my_posts = get_posts( $args );
										if ( $my_posts ) {
											foreach ( $my_posts as $post ) :
												setup_postdata( $post );
												?>
												<li class="p-item">
													<a href="<?php if(get_field('リンク')):?><?php the_field('リンク'); ?><?php else : ?><?php the_permalink(); ?><?php endif;?>" <?php if(get_field('別ウィンドウで開く')):?> target="_blank"<?php endif;?>>

														<div class="p-item__meta">
															<div class="p-item__date"><?php the_time('Y.m.d') ?></div>

															<?php if ($terms = get_the_terms($post->ID, 'update-cat')): ?>
															<ul class="c-label-list">
																<?php foreach ( $terms as $term ): ?>
																<li class="c-label<?php if( $term->name === '漁海況予報'){ echo ' c-label--theme-light';} ?>"><span class="main"><?php echo $term->name; ?></span></li>
																<?php endforeach; ?>
															</ul>
															<?php endif; ?>
														</div>
														<div class="p-item__title">
															<?php the_title(); ?>

															<?php if(get_field('別ウィンドウで開く')):?><i class="far fa-external-link-alt"></i><?php endif; ?>

														</div>
													</a>
												</li>

												<?php
											endforeach;
										} else {
											echo '登録がありません';
										}
										wp_reset_postdata();
									?>
								</ul>
							</div>


							<div class="js-panel p-tab-panel__item">
								<ul>
									<?php
										$args = array(
											'post_type' => 'update',
											'update-cat' => 'gk',
											'posts_per_page' => 3,
										);
										$my_posts = get_posts( $args );
										if ( $my_posts ) {
											foreach ( $my_posts as $post ) :
												setup_postdata( $post );
												?>
												<li class="p-item">
													<a href="<?php if(get_field('リンク')):?><?php the_field('リンク'); ?><?php else : ?><?php the_permalink(); ?><?php endif;?>" <?php if(get_field('別ウィンドウで開く')):?> target="_blank"<?php endif;?>>

														<div class="p-item__meta">
															<div class="p-item__date"><?php the_time('Y.m.d') ?></div>

															<?php if ($terms = get_the_terms($post->ID, 'update-cat')): ?>
															<ul class="c-label-list">
																<?php foreach ( $terms as $term ): ?>
																<li class="c-label<?php if( $term->name === '漁海況予報'){ echo ' c-label--theme-light';} ?>"><span class="main"><?php echo $term->name; ?></span></li>
																<?php endforeach; ?>
															</ul>
															<?php endif; ?>
														</div>
														<div class="p-item__title">
															<?php the_title(); ?>

															<?php if(get_field('別ウィンドウで開く')):?><i class="far fa-external-link-alt"></i><?php endif; ?>

														</div>
													</a>
												</li>

												<?php
											endforeach;
										} else {
											echo '登録がありません';
										}
										wp_reset_postdata();
									?>
								</ul>
							</div>


						</div>
					</div>

					<a href="<?php echo esc_url(home_url('/')); ?>update/" class="p-button p-button--arrow">更新情報一覧</a>
				</div>

			</div>
		</div>
	</section>

	<?php get_template_part('part', 'related-link'); ?>

</main>

<?php get_template_part('part', 'aside'); ?>
<?php get_template_part('part', 'banners'); ?>
<?php get_footer(); ?>