<?php
    $current_user   = wp_get_current_user();
    $user_id        = $current_user->ID;
    $profileuser    = get_userdata( $user_id );

?>

<?php if ( isset( $_POST['success-message'] ) ) : ?>
    <div class="alert-success alert alert-dismissible fade in" role="alert"><?php echo jnews_sanitize_by_pass( $_POST['success-message'] ); ?></div>
<?php endif ?>

<?php if ( isset( $_POST['error-message'] ) ) : ?>
    <div class="alert-error alert alert-dismissible fade in" role="alert"><?php echo jnews_sanitize_by_pass( $_POST['error-message'] ); ?></div>
<?php endif ?>

<form method="post" action="">
    <div class="row clearfix">
        <!-- first name -->
        <div class="col-md-6 fname-field">
            <div class="form-group">
                <label for="fname"><?php jnews_print_translation('First Name', 'jnews', 'first_name'); ?> <span class="required">*</span></label>
                <input id="fname" name="fname" placeholder="<?php jnews_print_translation('Insert your first name', 'jnews', 'first_name_desc'); ?>"  type="text" class="form-control" value="<?php echo isset( $user_firstname ) ? esc_attr( $user_firstname ) : ''; ?>">
            </div>
        </div>

        <!-- last name -->
        <div class="col-md-6 lname-field">
            <div class="form-group">
                <label for="lname"><?php jnews_print_translation('Last Name', 'jnews', 'last_name'); ?></label>
                <input id="lname" name="lname" placeholder="<?php jnews_print_translation('Insert your last name', 'jnews', 'last_name_desc'); ?>"  type="text" class="form-control" value="<?php echo isset( $user_lastname ) ? esc_attr( $user_lastname ) : ''; ?>">
            </div>
        </div>

        <!-- display name -->
        <div class="col-md-6 dname-field">
            <div class="form-group">
                <label for="dname"><?php jnews_print_translation('Display Name', 'jnews', 'display_name'); ?></label>
                <select name="dname" id="dname" class="jnews-select-chosen">
                    <?php
                        $public_display                     = array();
                        $public_display['display_nickname'] = $profileuser->nickname;
                        $public_display['display_username'] = $profileuser->user_login;

                    if ( ! empty( $profileuser->first_name ) ) {
                        $public_display['display_firstname'] = $profileuser->first_name;
                    }

                    if ( ! empty( $profileuser->last_name ) ) {
                        $public_display['display_lastname'] = $profileuser->last_name;
                    }

                    if ( ! empty( $profileuser->first_name ) && ! empty( $profileuser->last_name ) ) {
                        $public_display['display_firstlast'] = $profileuser->first_name . ' ' . $profileuser->last_name;
                        $public_display['display_lastfirst'] = $profileuser->last_name . ' ' . $profileuser->first_name;
                    }

                    if ( ! in_array( $profileuser->display_name, $public_display, true ) ) { // Only add this if it isn't duplicated elsewhere.
                        $public_display = array( 'display_displayname' => $profileuser->display_name ) + $public_display;
                    }

                        $public_display = array_map( 'trim', $public_display );
                        $public_display = array_unique( $public_display );

                    foreach ( $public_display as $id => $item ) {
                        ?>
                    <option <?php selected( $profileuser->display_name, $item ); ?>><?php echo $item; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>

        <?php
            do_action( 'jnews_insert_after_display_name', $user_id  ); 
        ?>

        <!-- social -->
        <div class="col-md-12 social-label">
            <h3 class="clearfix"><?php jnews_print_translation( 'Contact Info', 'jnews', 'contact_info' ) ?></h3>
        </div>

		<?php foreach ( $socials as $key => $value ): ?>
            <div class="col-md-6 <?php echo esc_attr( $key ); ?>-field">
                <div class="form-group">
                    <label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value['label'] ); ?></label>
                    <input id="<?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $key ); ?>"  type="text" class="form-control" value="<?php echo isset( $value['value'] ) ? esc_attr( $value['value'] ) : ''; ?>">
                </div>
            </div>
		<?php endforeach ?>

        <!-- description -->
        <div class="col-md-12 description-label">
            <h3 class="clearfix"><?php jnews_print_translation( 'About Yourself', 'jnews', 'about_yourself' ); ?></h3>
        </div>

        <div class="col-md-12 description-field">
            <div class="form-group">
                <label for="description"><?php jnews_print_translation('Biographical Info', 'jnews', 'biographical_info'); ?></label>
				<?php
				wp_editor( $description, 'description', array(
					'textarea_name' 	=> 'description',
					'drag_drop_upload' 	=> false,
					'media_buttons' 	=> false,
					'textarea_rows' 	=> 10,
					'teeny' 			=> true,
					'quicktags' 		=> false
				));
				?>
            </div>
        </div>

        <!-- profile picture -->
        <?php if ( current_user_can( 'upload_files' ) ) { ?>
            <div class="col-md-12 photo-field">
                <div class="form-group">
                    <label for="photo"><?php jnews_print_translation('Profile Picture', 'jnews', 'profile_picture'); ?></label>
                    <div class="form-input-wrapper">
                        <?php
                        jeg_locate_template( locate_template('fragment/upload/upload-form.php', false, false), true, array(
                            'id' 		=> 'photo',
                            'class'		=> '',
                            'name' 		=> 'photo',
                            'source' 	=> isset( $photo ) ? $photo : '',
                            'button' 	=> 'btn-single-image',
                            'multi' 	=> false,
                            'maxsize' 	=> apply_filters( 'jnews_maxsize_upload_profile_picture', '2mb' )
                        ));
                        ?>
                    </div>
                </div>
            </div>
        <?php } ?>

        <!-- submit -->
        <div class="col-md-12 submit-field">
            <div class="form-group">

				<?php if ( ! apply_filters( 'jnews_account_disable_edit_account', false ) ): ?>
                    <input type="hidden" name="jnews-action" value="edit-account" />
                    <input type="hidden" name="user_id" value="<?php echo esc_attr( get_current_user_id() ); ?>" />
                    <input type="hidden" name="jnews-account-nonce" value="<?php echo esc_attr( wp_create_nonce('jnews-account-nonce') ); ?>"/>
                    <input type="submit" value="<?php jnews_print_translation('Edit Account', 'jnews', 'edit_account_button'); ?>"/>
				<?php else: ?>
					<?php echo apply_filters( 'jnews_account_disable_edit_account_msg', '' ); ?>
				<?php endif ?>

            </div>
        </div>

    </div>
</form>
