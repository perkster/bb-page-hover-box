<?php
/**
 * BB Page Hover Box: Widget Admin Form 
 */

// Block direct requests
if ( !defined( 'ABSPATH' ) )
	die( '-1' );

?>
<div class="bb-phb-widget">
	<div class="section">
		<h4><?php _e( 'Link options', $this->get_widget_text_domain() ); ?></h4>
		<p class="cf">Select either id or url. If id is not empty, it will be used automatically.</p>
		<p class="cf">
          <label for="<?php echo $this->get_field_id( 'post_id' ); ?>"><?php _e( 'ID of post/page to show:', $this->get_widget_text_domain() ); ?></label> 
          <input id="<?php echo $this->get_field_id( 'post_id' ); ?>" name="<?php echo $this->get_field_name( 'post_id' ); ?>" type="text" value="<?php echo $post_id; ?>" />
        </p>
		<p class="cf">
          <label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'URL to link to:', $this->get_widget_text_domain() ); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo $link; ?>" />
        </p>
	</div>
	<div class="section display">
		<h4><?php _e( 'Display Options', $this->get_widget_text_domain() ); ?></h4>
		<p class="cf">
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Widget title:', $this->get_widget_text_domain() ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
		<div class="check">
          <input class="bbphb-icons" id="<?php echo $this->get_field_id( 'icon' ); ?>" name="<?php echo $this->get_field_name( 'icon' ); ?>" type="checkbox" value="1" <?php checked( '1', $icon ); ?>/>
          <label style="font-weight:bold;" for="<?php echo $this->get_field_id( 'icon' ); ?>"><?php _e( 'Display icons?', $this->widget_text_domain ); ?></label> 
        </div>
		<div class="bbphb-icons__settings">
			<p class="cf">
			  <label for="<?php echo $this->get_field_id( 'iconclass' ); ?>"><?php _e( 'Icon class:', $this->get_widget_text_domain() ); ?></label> 
			  <input id="<?php echo $this->get_field_id( 'iconclass' ); ?>" name="<?php echo $this->get_field_name( 'iconclass' ); ?>" type="text" value="<?php echo $iconclass; ?>" />
			</p>
			<p class="cf">
			  <label for="<?php echo $this->get_field_id( 'link_text' ); ?>"><?php _e( 'Link text:', $this->get_widget_text_domain() ); ?></label> 
			  <input id="<?php echo $this->get_field_id( 'link_text' ); ?>" name="<?php echo $this->get_field_name( 'link_text' ); ?>" type="text" value="<?php echo esc_html($link_text); ?>" />
			</p>	
		</div>
	</div>
	
	<div class="section thumbnails">
		<p class="check">
          <input class="bb-phb-thumbnail" id="<?php echo $this->get_field_id( 'thumbnail' ); ?>" name="<?php echo $this->get_field_name( 'thumbnail' ); ?>" type="checkbox" value="1" <?php checked( '1', $thumbnail ); ?>/>
          <label style="font-weight:bold;" for="<?php echo $this->get_field_id( 'thumbnail' ); ?>"><?php _e( 'Display thumbnail?', $this->get_widget_text_domain() ); ?></label> 
        </p>
		<p class="thumb-size">	
			<label for="<?php echo $this->get_field_id( 'thumbsize' ); ?>"><?php _e( 'Select a thumbnail size to show:', $this->get_widget_text_domain() ); ?></label> 
			<select class="widefat" name="<?php echo $this->get_field_name( 'thumbsize' ); ?>" id="<?php echo $this->get_field_id( 'thumbsize' ); ?>">
				<?php
				foreach ($this->thumbsizes as $option) {
					echo '<option value="' . $option . '" id="' . $this->get_field_id( $option ) . '"', $thumbsize == $option ? ' selected="selected"' : '', '>', $option, '</option>';
				}
				?>
			</select>		
		</p>
		<p class="cf">
			<label for="<?php echo $this->get_field_id( 'img_override' ); ?>"><?php _e( 'Image override:', $this->get_widget_text_domain() ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'img_override' ); ?>" name="<?php echo $this->get_field_name( 'img_override' ); ?>" type="text" value="<?php echo esc_html($img_override); ?>" />
		</p>	
	</div>
	<div class="section excerpt">
		<p class="cf">
			<label for="<?php echo $this->get_field_id( 'excerpt_override' ); ?>"><?php _e( 'Excerpt override:', $this->get_widget_text_domain() ); ?></label> 
			<textarea class="widefat" id="<?php echo $this->get_field_id( 'excerpt_override' ); ?>" name="<?php echo $this->get_field_name( 'excerpt_override' ); ?>" ><?php echo esc_html($excerpt_override); ?></textarea>
		</p>	
	</div>
	
	<div class="section templates">
		<h4><?php _e( 'Template Options', $this->get_widget_text_domain() ); ?></h4>
		<p class="cf">
			<label for="<?php echo $this->get_field_id( 'template' ); ?>"><?php _e( 'Template filename:', $this->get_widget_text_domain() ); ?></label>
			<?php 
			?>
			<select class="widefat" name="<?php echo $this->get_field_name( 'template' ); ?>" id="<?php echo $this->get_field_id( 'template' ); ?>">
				<?php
				foreach ($this->templates as $key => $value ) {
					echo '<option value="' . $key . '" id="' . $this->get_field_id( $key ) . '"', $template == $key ? ' selected="selected"' : '', '>', ucwords( preg_replace( array( '/-/', '/_/' ), ' ', preg_replace( '/.php$/', '', $key ) ) ), '</option>';
				}
				?>
			</select>		
		</p>
	</div>
	
</div><!-- .bb-phb-widget -->
