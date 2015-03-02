<?php
/**
 * BB Page Hover Box: Default widget template
 * 
 * @since 1.0.0
 *
 * This template was added to give a starting point.
 */

 // Block direct requests
if ( !defined('ABSPATH') )
	die('-1');

echo $before_widget;


if( $phb_info ):  //prar($phb_info);
	//Check for icon
	if($phb_info['icon']) {
		$icon = '<i class="bb-phb__icon ' . $phb_info['iconclass'] . '"></i>';
	} else {
		$icon = null;
	}
	
	//$image = phb_image($post_id, $thumbsize, $classes);
	//Check for image
	if($phb_info['thumbnail']) {
		$img_attr = array ( 'class' => 'bb-phb__img' );
		$image = phb_image($phb_info['post_id'], $phb_info['thumbsize'], $img_attr);		
	}
	if( !isset($image) || !$image ) {
		$image = '<div class="bb-phb__img--none">&nbsp;</div>';
	}
?>
	<div class="bb-phb">
		<div class="bb-phb__box">
			<a href="<?php echo get_permalink( $phb_info['post_id']); ?>" class="bb-phb__link">
                <?php echo $image; ?>
				<div class="bb-phb__info home-phb__info">
					<div class="bb-phb__icon-wrapper"><div class="bb-phb__icon-inner"><?php echo $icon; ?></div></div>
					<div class="bb-phb__content-wrapper"><div class="bb-phb__content-inner">
						<div class="bb-phb__title-text"><p><?php echo $phb_info['title']; ?></p></div>
						<div class="bb-phb__content">
							<p><?php echo bb_phb_excerpt( $phb_info['post_id'], 30 ); ?></p>
							<p class="bb-phb__link-text-wrapper"><span class="bb-phb__link-text"><?php echo $phb_info['link_text']; ?></span></p>
						</div>
					</div></div>
				</div>                  
			</a>
		</div>
	</div>

<?php	
endif; // End $phb_info
	
echo $after_widget;
?>