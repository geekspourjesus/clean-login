<?php
/**
 * @package Clean_Login
 * @version 1.4.1
 */
/*
Plugin Name: Clean Login
Plugin URI: http://cleanlogin.codection.com
Description: Responsive Frontend Login and Registration plugin. A plugin for displaying login, register, editor and restore password forms through shortcodes. [clean-login] [clean-login-edit] [clean-login-register] [clean-login-restore]
Author: codection
Version: 1.4.1
Author URI: https://codection.com
*/

/**
 * Enqueue plugin style
 *
 * @since 0.8
 */
function clean_login_enqueue_style() {
    wp_register_style( 'css', plugins_url( 'content/style.css', __FILE__ ) );
    wp_enqueue_style( 'css' );
}
add_action( 'wp_enqueue_scripts', 'clean_login_enqueue_style' ); 

/**
 * [clean-login] shortcode
 *
 * @since 0.8
 */
function show_clean_login($atts) {

	ob_start();
	
	if ( isset( $_GET['authentication'] ) ) {
		if ( $_GET['authentication'] == 'success' )
			echo "<div class='cleanlogin-notification success'><p>". __( 'Successfully logged in!', 'cleanlogin' ) ."</p></div>";
		else if ( $_GET['authentication'] == 'failed' )
			echo "<div class='cleanlogin-notification error'><p>". __( 'Wrong credentials', 'cleanlogin' ) ."</p></div>";
		else if ( $_GET['authentication'] == 'logout' )
			echo "<div class='cleanlogin-notification success'><p>". __( 'Successfully logged out!', 'cleanlogin' ) ."</p></div>";
	}

	if ( is_user_logged_in() ) {
		// show user preview data
		require( 'content/login-preview.php' );

	} else {
		// show login form
		require( 'content/login-form.php' );
	}

	return ob_get_clean();

}
add_shortcode('clean-login', 'show_clean_login');

/**
 * [clean-login-edit] shortcode
 *
 * @since 0.8
 */
function show_clean_login_edit($atts) {
	
	ob_start();

	if ( isset( $_GET['updated'] ) ) {
		if ( $_GET['updated'] == 'success' )
			echo "<div class='cleanlogin-notification success'><p>". __( 'Information updated', 'cleanlogin' ) ."</p></div>";
		else if ( $_GET['updated'] == 'passcomplex' )
			echo "<div class='cleanlogin-notification error'><p>". __( 'Passwords must be eight characters including one upper/lowercase letter, one special/symbol character and alphanumeric characters. Passwords should not contain the user\'s username, email, or first/last name.', 'cleanlogin' ) ."</p></div>";
		else if ( $_GET['updated'] == 'wrongpass' )
			echo "<div class='cleanlogin-notification error'><p>". __( 'Passwords must be identical', 'cleanlogin' ) ."</p></div>";
		else if ( $_GET['updated'] == 'wrongmail' )
			echo "<div class='cleanlogin-notification error'><p>". __( 'Error updating email', 'cleanlogin' ) ."</p></div>";
		else if ( $_GET['updated'] == 'failed' )
			echo "<div class='cleanlogin-notification error'><p>". __( 'Something strange has ocurred', 'cleanlogin' ) ."</p></div>";
	}

	if ( is_user_logged_in() ) {
		require( 'content/login-edit.php' );
	} else {
		echo "<div class='cleanlogin-notification error'><p>". __( 'You need to be logged in to edit your profile', 'cleanlogin' ) ."</p></div>";
		require( 'content/login-form.php' );
		/*$login_url = get_option( 'cl_login_url', '');
		if ( $login_url != '' )
			echo "<script>window.location = '$login_url'</script>";*/
	}

	return ob_get_clean();

}
add_shortcode('clean-login-edit', 'show_clean_login_edit');

/**
 * [clean-login-register] shortcode
 *
 * @since 0.8
 */
function show_clean_login_register($atts) {
	
	$param = shortcode_atts( array(
        'role' => false,
    ), $atts );

	ob_start();

	if ( isset( $_GET['created'] ) ) {
		if ( $_GET['created'] == 'success' )
			echo "<div class='cleanlogin-notification success'><p>". __( 'User created', 'cleanlogin' ) ."</p></div>";
		else if ( $_GET['created'] == 'created' )
			echo "<div class='cleanlogin-notification success'><p>". __( 'New user created', 'cleanlogin' ) ."</p></div>";
		else if ( $_GET['created'] == 'passcomplex' )
			echo "<div class='cleanlogin-notification error'><p>". __( 'Passwords must be eight characters including one upper/lowercase letter, one special/symbol character and alphanumeric characters. Passwords should not contain the user\'s username, email, or first/last name.', 'cleanlogin' ) ."</p></div>";
		else if ( $_GET['created'] == 'wronguser' )
			echo "<div class='cleanlogin-notification error'><p>". __( 'Username is not valid', 'cleanlogin' ) ."</p></div>";
		else if ( $_GET['created'] == 'wrongpass' )
			echo "<div class='cleanlogin-notification error'><p>". __( 'Passwords must be identical and filled', 'cleanlogin' ) ."</p></div>";
		else if ( $_GET['created'] == 'wrongmail' )
			echo "<div class='cleanlogin-notification error'><p>". __( 'Email is not valid', 'cleanlogin' ) ."</p></div>";
		else if ( $_GET['created'] == 'wrongcaptcha' )
			echo "<div class='cleanlogin-notification error'><p>". __( 'CAPTCHA is not valid, please try again', 'cleanlogin' ) ."</p></div>";
		else if ( $_GET['created'] == 'failed' )
			echo "<div class='cleanlogin-notification error'><p>". __( 'Something strange has ocurred while created the new user', 'cleanlogin' ) ."</p></div>";
	}

	if ( !is_user_logged_in() ) {
		require( 'content/register-form.php' );
	} else {
		echo "<div class='cleanlogin-notification error'><p>". __( 'You are now logged in. It makes no sense to register a new user', 'cleanlogin' ) ."</p></div>";
		require( 'content/login-preview.php' );
		/*$login_url = get_option( 'cl_login_url', '');
		if ( $login_url != '' )
			echo "<script>window.location = '$login_url'</script>";*/
	}

	return ob_get_clean();

}
add_shortcode('clean-login-register', 'show_clean_login_register');

/**
 * [clean-login-restore] shortcode
 *
 * @since 0.8
 */
function show_clean_login_restore($atts) {

	ob_start();

	if ( isset( $_GET['sent'] ) ) {
		if ( $_GET['sent'] == 'success' )
			echo "<div class='cleanlogin-notification success'><p>". __( 'You will receive an email with the activation link', 'cleanlogin' ) ."</p></div>";
		else if ( $_GET['sent'] == 'sent' )
			echo "<div class='cleanlogin-notification success'><p>". __( 'You may receive an email with the activation link', 'cleanlogin' ) ."</p></div>";
		else if ( $_GET['sent'] == 'failed' )
			echo "<div class='cleanlogin-notification error'><p>". __( 'An error has ocurred sending the email', 'cleanlogin' ) ."</p></div>";
		else if ( $_GET['sent'] == 'wronguser' )
			echo "<div class='cleanlogin-notification error'><p>". __( 'Username is not valid', 'cleanlogin' ) ."</p></div>";
	}

	if ( !is_user_logged_in() ) {
		if ( isset( $_GET['pass'] ) ) {
			$new_password = $_GET['pass'];
			$login_url = get_option( 'cl_login_url', '');
			require( 'content/restore-new.php' );
		} else
			require( 'content/restore-form.php' );
	} else {
		echo "<div class='cleanlogin-notification error'><p>". __( 'You are now logged in. It makes no sense to restore your account', 'cleanlogin' ) ."</p></div>";
		require( 'content/login-preview.php' );
		/*$login_url = get_option( 'cl_login_url', '');
		if ( $login_url != '' )
			echo "<script>window.location = '$login_url'</script>";*/
	}

	return ob_get_clean();

}
add_shortcode('clean-login-restore', 'show_clean_login_restore');


/**
 * Password complexity checker
 *
 * @since 1.2
 */
function is_password_complex($candidate) {

	if (!preg_match_all('$\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$', $candidate))
        return false;
    return true;

    /* Explaining $\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$
    $ = beginning of string
    \S* = any set of characters
    (?=\S{8,}) = of at least length 8
    (?=\S*[a-z]) = containing at least one lowercase letter
    (?=\S*[A-Z]) = and at least one uppercase letter
    (?=\S*[\d]) = and at least one number
    (?=\S*[\W]) = and at least a special character (non-word characters)
    $ = end of the string */
}


/**
 * Custom code to be loaded before headers
 *
 * @since 0.8
 */
function clean_login_load_before_headers() {
	global $wp_query; 
	if ( is_singular() ) { 
		$post = $wp_query->get_queried_object(); 
		// If contains any shortcode of our ones
		if ( strpos($post->post_content, 'clean-login' ) !== false ) {

			// Sets the redirect url to the current page 
			$url = clean_login_url_cleaner( wp_get_referer() );

			// LOGIN
			if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'login' ) {
				$login_url = get_option( 'cl_login_url', '');
				if ( $login_url != '' )
					$url = $login_url;
				$user = wp_signon();
				if ( is_wp_error( $user ) )
					$url = esc_url( add_query_arg( 'authentication', 'failed', $url ) );
				else
					$url = esc_url( add_query_arg( 'authentication', 'success', $url ) );

				wp_safe_redirect( $url );

			// LOGOUT
			} else if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'logout' ) {
				wp_logout();
				$url = esc_url( add_query_arg( 'authentication', 'logout', $url ) );
				
				wp_safe_redirect( $url );

			// EDIT profile
			} else if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'edit' ) {
				$url = esc_url( add_query_arg( 'updated', 'success', $url ) );

				$current_user = wp_get_current_user();
				$userdata = array( 'ID' => $current_user->ID );

				$first_name = isset( $_POST['first_name'] ) ? $_POST['first_name'] : '';
				$last_name = isset( $_POST['last_name'] ) ? $_POST['last_name'] : '';
				$userdata['first_name'] = $first_name;
				$userdata['last_name'] = $last_name;
			
				$email = isset( $_POST['email'] ) ? $_POST['email'] : '';
				if ( ! $email || empty ( $email ) ) {
					$url = esc_url( add_query_arg( 'updated', 'wrongmail', $url ) );
				} elseif ( ! is_email( $email ) ) {
					$url = esc_url( add_query_arg( 'updated', 'wrongmail', $url ) );
				} elseif ( ( $email != $current_user->user_email ) && email_exists( $email ) ) {
					$url = esc_url( add_query_arg( 'updated', 'wrongmail', $url ) );
				} else {
					$userdata['user_email'] = $email;
				}

				// check if password complexity is checked
				$enable_passcomplex = get_option( 'cl_passcomplex' ) == 'on' ? true : false;

				// password checker
				if ( isset( $_POST['pass1'] ) && ! empty( $_POST['pass1'] ) ) {
					if ( ! isset( $_POST['pass2'] ) || ( isset( $_POST['pass2'] ) && $_POST['pass2'] != $_POST['pass1'] ) ) {
						$url = esc_url( add_query_arg( 'updated', 'wrongpass', $url ) );
					}
					else {
						if( $enable_passcomplex && !is_password_complex($_POST['pass1']) )
							$url = esc_url( add_query_arg( 'updated', 'passcomplex', $url ) );
						else
							$userdata['user_pass'] = $_POST['pass1'];
					}
					
				}

				$user_id = wp_update_user( $userdata );
				if ( is_wp_error( $user_id ) ) {
					$url = esc_url( add_query_arg( 'updated', 'failed', $url ) );
				}

				wp_safe_redirect( $url );

			// REGISTER a new user
			} else if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'register' ) {
				$url = esc_url( add_query_arg( 'created', 'success', $url ) );

				$username = isset( $_POST['username'] ) ? $_POST['username'] : '';
				$email = isset( $_POST['email'] ) ? $_POST['email'] : '';
				$pass1 = isset( $_POST['pass1'] ) ? $_POST['pass1'] : '';
				$pass2 = isset( $_POST['pass2'] ) ? $_POST['pass2'] : '';
				$website = isset( $_POST['website'] ) ? $_POST['website'] : '';
				$captcha = isset( $_POST['captcha'] ) ? $_POST['captcha'] : '';
				$captcha_session = isset( $_SESSION['cleanlogin-captcha'] ) ? $_SESSION['cleanlogin-captcha'] : '';
				$role = isset( $_POST['role'] ) ? $_POST['role'] : '';

				// check if captcha is checked
				$enable_captcha = get_option( 'cl_antispam' ) == 'on' ? true : false;
				// check if standby role is checked
				$create_standby_role = get_option( 'cl_standby' ) == 'on' ? true : false;
				// check if password complexity is checked
				$enable_passcomplex = get_option( 'cl_passcomplex' ) == 'on' ? true : false;
				// check if custom role is selected and get the roles choosen
				$create_customrole = get_option( 'cl_chooserole' ) == 'on' ? true : false;
				$newuserroles = get_option ( 'cl_newuserroles' );
				// check if the user should receive an email
				$emailnotification = get_option ( 'cl_emailnotification' );
    			$emailnotificationcontent = get_option ( 'cl_emailnotificationcontent' );

				// password complexity checker
				if( $enable_passcomplex && !is_password_complex($pass1) )
					$url = esc_url( add_query_arg( 'created', 'passcomplex', $url ) );
				// check if the selected role is contained in the roles selected in CL
				else if ( $create_customrole && !in_array($role, $newuserroles))
					$url = esc_url( add_query_arg( 'created', 'failed', $url ) );
				// captcha enabled
				else if( $enable_captcha && $captcha != $captcha_session )
					$url = esc_url( add_query_arg( 'created', 'wrongcaptcha', $url ) );
				// honeypot detection
				else if( $website != ' ' )
					$url = esc_url( add_query_arg( 'created', 'created', $url ) );
				else if( $username == '' || username_exists( $username ) )
					$url = esc_url( add_query_arg( 'created', 'wronguser', $url ) );
				else if( $email == '' || email_exists( $email ) || !is_email( $email ) )
					$url = esc_url( add_query_arg( 'created', 'wrongmail', $url ) );
				else if ( $pass1 == '' || $pass1 != $pass2)
					$url = esc_url( add_query_arg( 'created', 'wrongpass', $url ) );
				else {
					$user_id = wp_create_user( $username, $pass1, $email );
					if ( is_wp_error( $user_id ) )
						$url = esc_url( add_query_arg( 'created', 'failed', $url ) );
					else {
						$user = new WP_User( $user_id );
						if( $create_customrole )
							$user->set_role( $role );
						else if ( $create_standby_role )
							$user->set_role( 'standby' );
						
						$adminemail = get_bloginfo( 'admin_email' );
						$blog_title = get_bloginfo();
						if ( $create_standby_role )
							$message = sprintf( __( "New user registered: %s <br/><br/>Please change the role from 'Stand By' to 'Subscriber' or higher to allow full site access", 'cleanlogin' ), $username );
						else
							$message = sprintf( __( "New user registered: %s <br/>", 'cleanlogin' ), $username );
						
						$subject = "[$blog_title] " . __( 'New user', 'cleanlogin' );
						add_filter( 'wp_mail_content_type', 'clean_login_set_html_content_type' );
						if( !wp_mail( $adminemail, $subject, $message ) )
							$url = esc_url( add_query_arg( 'sent', 'failed', $url ) );
						remove_filter( 'wp_mail_content_type', 'clean_login_set_html_content_type' );

						if( $emailnotification ) {
							$emailnotificationcontent = str_replace("{username}", $username, $emailnotificationcontent);
							$emailnotificationcontent = str_replace("{password}", $pass1, $emailnotificationcontent);
							$emailnotificationcontent = str_replace("{email}", $email, $emailnotificationcontent);
							
							add_filter( 'wp_mail_content_type', 'clean_login_set_html_content_type' );
							if( !wp_mail( $email, $subject , $emailnotificationcontent ) )
								$url = esc_url( add_query_arg( 'sent', 'failed', $url ) );
							remove_filter( 'wp_mail_content_type', 'clean_login_set_html_content_type' );
						}
					}
				}

				wp_safe_redirect( $url );

			// RESTORE a password by sending an email with the activation link
			} else if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'restore' ) {
				$url = esc_url( add_query_arg( 'sent', 'success', $url ) );

				$username = isset( $_POST['username'] ) ? $_POST['username'] : '';
				$website = isset( $_POST['website'] ) ? $_POST['website'] : '';

				// Since 1.1 (get username from email if so)
				if ( is_email( $username ) ) {
					$userFromMail = get_user_by( 'email', $username );
					if ( $userFromMail == false )
						$username = '';
					else
						$username = $userFromMail->user_login;
				}

				// honeypot detection
				if( $website != ' ' )
					$url = esc_url( add_query_arg( 'sent', 'sent', $url ) );
				else if( $username == '' || !username_exists( $username ) )
					$url = esc_url( add_query_arg( 'sent', 'wronguser', $url ) );
				else {
					$user = get_user_by( 'login', $username );

					$url_msg = get_permalink();
					$url_msg = esc_url( add_query_arg( 'restore', $user->ID, $url_msg ) );
					$url_msg = wp_nonce_url( $url_msg, $user->ID );

					$email = $user->user_email;
					$blog_title = get_bloginfo();
					$message = sprintf( __( "Use the following link to restore your password: <a href='%s'>restore your password</a> <br/><br/>%s<br/>", 'cleanlogin' ), $url_msg, $blog_title );

					$subject = "[$blog_title] " . __( 'Restore your password', 'cleanlogin' );
					add_filter( 'wp_mail_content_type', 'clean_login_set_html_content_type' );
					if( !wp_mail( $email, $subject , $message ) )
						$url = esc_url( add_query_arg( 'sent', 'failed', $url ) );
					remove_filter( 'wp_mail_content_type', 'clean_login_set_html_content_type' );

				}

				wp_safe_redirect( $url );

			// When a user click the activation link goes here to RESTORE his/her password
			} else if ( isset( $_REQUEST['restore'] ) ) {
				

				$user_id = $_REQUEST['restore'];

				$retrieved_nonce = $_REQUEST['_wpnonce'];
				if ( !wp_verify_nonce($retrieved_nonce, $user_id ) )
					die( 'Failed security check, expired Activation Link due to duplication or date.' );

				$edit_url = get_option( 'cl_edit_url', '');
				
				// If edit profile page exists the user will be redirected there
				if( $edit_url != '') {
					wp_clear_auth_cookie();
				    wp_set_current_user ( $user_id );
				    wp_set_auth_cookie  ( $user_id );
				    $url = $edit_url;

				// If not, a new password will be generated and notified
				} else {
					$url = get_option( 'cl_restore_url', '');
					// check if password complexity is checked
					$enable_passcomplex = get_option( 'cl_passcomplex' ) == 'on' ? true : false;
					
					if($enable_passcomplex)
						$new_password = wp_generate_password(12, true);
					else
						$new_password = wp_generate_password(8, false);

					$user_id = wp_update_user( array( 'ID' => $user_id, 'user_pass' => $new_password ) );

					if ( is_wp_error( $user_id ) ) {
						$url = esc_url( add_query_arg( 'sent', 'wronguser', $url ) );
					} else {
						$url = esc_url( add_query_arg( 'pass', $new_password, $url ) );
					}
				}

				wp_safe_redirect( $url );
			}
		} 
	}
}
add_action('template_redirect', 'clean_login_load_before_headers');

/**
 * Cleans an url
 *
 * @since 0.8
 * @param url to be cleaned
 */
function clean_login_url_cleaner( $url ) {
	$query_args = array(
		'authentication',
		'updated',
		'created',
		'sent',
		'restore'
	);
	return esc_url( remove_query_arg( $query_args, $url ) );
}

/**
 * Set email format to html
 *
 * @since 0.8
 */
function clean_login_set_html_content_type()
{
    return 'text/html';
}

/**
 * It will only display the admin bar for users with administrative privileges
 *
 * @since 0.8
 */
function clean_login_remove_admin_bar() {
	$remove_adminbar = get_option( 'cl_adminbar' ) == 'on' ? true : false;

	if ( $remove_adminbar && !current_user_can( 'manage_options' ) )
    	show_admin_bar( false );
}
add_action('after_setup_theme', 'clean_login_remove_admin_bar');

/**
 * It will only enable the dashboard for users with administrative privileges
 * Please note that you can only log in through wp-login.php and this plugin
 *
 * @since 0.9
 */
function clean_login_block_dashboard_access() {
	$block_dashboard = get_option( 'cl_dashboard' ) == 'on' ? true : false;

	if ( $block_dashboard && !current_user_can( 'manage_options' ) && ( !defined( 'DOING_AJAX' ) || !DOING_AJAX ) ) {
		wp_redirect( home_url() );
		exit;
	}
}
add_action( 'admin_init', 'clean_login_block_dashboard_access', 1 );

/**
 * session_start();
 *
 * @since 0.9
 */

function clean_login_register_session(){
    if( !session_id() )
        session_start();
}
add_action('init','clean_login_register_session');

/**
 * Detect shortcodes and update the plugin options
 *
 * @since 0.8
 * @param post_id of an updated post
 */
function clean_login_get_pages_with_shortcodes( $post_id ) {

	$revision = wp_is_post_revision( $post_id );

	if ( $revision ) $post_id = $revision;
	
	$post = get_post( $post_id );

	if ( has_shortcode( $post->post_content, 'clean-login' ) ) {
		update_option( 'cl_login_url', get_permalink( $post->ID ) );
	}

	if ( has_shortcode( $post->post_content, 'clean-login-edit' ) ) {
		update_option( 'cl_edit_url', get_permalink( $post->ID ) );
	}

	if ( has_shortcode( $post->post_content, 'clean-login-register' ) ) {
		update_option( 'cl_register_url', get_permalink( $post->ID ) );
	}

	if ( has_shortcode( $post->post_content, 'clean-login-restore' ) ) {
		update_option( 'cl_restore_url', get_permalink( $post->ID ) );
	}

}
add_action( 'save_post', 'clean_login_get_pages_with_shortcodes' );

/**
 * Add a role without any capability
 *
 * @since 0.8
 */
function clean_login_add_roles() {

	$create_standby_role = get_option( 'cl_standby' ) == 'on' ? true : false;
	$role = get_role( 'standby' );

	if ( $create_standby_role ) {
		// create if neccesary
	    if ( !$role )
	    	$role = add_role('standby', 'StandBy');
		// and remove capabilities
		$role->remove_cap( 'read' );
	} else {
		// remove if exists
		if ( $role )
			remove_role( 'standby' );
	}
}
add_action( 'admin_init', 'clean_login_add_roles');

/**
* Add plugin text domain
*
* @since 0.8
*/
function clean_login_load_textdomain(){
	load_plugin_textdomain( 'cleanlogin', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
}
add_action( 'plugins_loaded', 'clean_login_load_textdomain' );


/*  __               __                  __               __  _                 
   / /_  ____ ______/ /_____  ____  ____/ /  ____  ____  / /_(_)___  ____  _____
  / __ \/ __ `/ ___/ //_/ _ \/ __ \/ __  /  / __ \/ __ \/ __/ / __ \/ __ \/ ___/
 / /_/ / /_/ / /__/ ,< /  __/ / / / /_/ /  / /_/ / /_/ / /_/ / /_/ / / / (__  ) 
/_.___/\__,_/\___/_/|_|\___/_/ /_/\__,_/   \____/ .___/\__/_/\____/_/ /_/____/  
                                               /_/                              
*/

/**
* Backend options
*
* @since 0.9
*/

function clean_login_menu() {
    add_options_page( 'Clean Login Options', 'Clean Login', 'manage_options', 'clean_login_menu', 'clean_login_options' );
}
add_action( 'admin_menu', 'clean_login_menu' );
 
function clean_login_options() {
    // No debería ser necesario, pero no está de más
    if (!current_user_can('manage_options')){
        wp_die( __('Admin area', 'clean-login') );
    }

    // Comprobar el estado del plugin y mostrarlo
    $login_url = get_option( 'cl_login_url');
	$edit_url = get_option( 'cl_edit_url');
	$register_url = get_option( 'cl_register_url');
	$restore_url = get_option( 'cl_restore_url');

    ?>
	    <div class="wrap">
	        <h2>Clean Login status</h2>

	        <p><?php echo __( 'Below you can check the plugin status regarding the shortcodes usage and the pages/posts which contain  it.', 'cleanlogin' ); ?></p>


	    	<table class="widefat importers">
				<tbody>
					<tr class="alternate">
						<td class="import-system row-title"><a>[clean-login]</a></td>
						<?php if( !$login_url ): ?>
							<td class="desc"><?php echo __( 'Currently not used', 'cleanlogin' ); ?></td>
						<?php else: ?>
							<td class="desc"><?php printf( __( 'Used <a href="%s">here</a>', 'cleanlogin' ), $login_url ); ?></td>
						<?php endif; ?>
						<td class="desc"><?php echo __( 'This shortcode contains login form and login information.', 'cleanlogin' ); ?></td>
					</tr>
					<tr>
						<td class="import-system row-title"><a>[clean-login-edit]</a></td>
						<?php if( !$edit_url ): ?>
							<td class="desc"><?php echo __( 'Currently not used', 'cleanlogin' ); ?></td>
						<?php else: ?>
							<td class="desc"><?php printf( __( 'Used <a href="%s">here</a>', 'cleanlogin' ), $edit_url ); ?></td>
						<?php endif; ?>
						<td class="desc"><?php echo __( 'This shortcode contains the profile editor. If you include in a page/post a link will appear on your login preview.', 'cleanlogin' ); ?></td>
					</tr>
					<tr class="alternate">
						<td class="import-system row-title"><a>[clean-login-register]</a></td>
						<?php if( !$register_url ): ?>
							<td class="desc"><?php echo __( 'Currently not used', 'cleanlogin' ); ?></td>
						<?php else: ?>
							<td class="desc"><?php printf( __( 'Used <a href="%s">here</a>', 'cleanlogin' ), $register_url ); ?></td>
						<?php endif; ?>
						<td class="desc"><?php echo __( 'This shortcode contains the register form. If you include in a page/post a link will appear on your login form.', 'cleanlogin' ); ?></td>
					</tr>
					<tr>
						<td class="import-system row-title"><a>[clean-login-restore]</a></td>
						<?php if( !$restore_url ): ?>
							<td class="desc"><?php echo __( 'Currently not used', 'cleanlogin' ); ?></td>
						<?php else: ?>
							<td class="desc"><?php printf( __( 'Used <a href="%s">here</a>', 'cleanlogin' ), $restore_url ); ?></td>
						<?php endif; ?>
						<td class="desc"><?php echo __( 'This shortcode contains the restore (lost password?) form. If you include in a page/post a link will appear on your login form.', 'cleanlogin' ); ?></td>
					</tr>
				</tbody>
			</table>

			<h2>Options</h2>

    <?php

    $hidden_field_name = 'cl_hidden_field';
    $hidden_field_value = 'hidden_field_to_update_others';

    if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == $hidden_field_value ) {

        update_option( 'cl_adminbar', isset( $_POST['adminbar'] ) ? $_POST['adminbar'] : '' );
        update_option( 'cl_dashboard', isset( $_POST['dashboard'] ) ? $_POST['dashboard'] : '' );
        update_option( 'cl_antispam', isset( $_POST['antispam'] ) ? $_POST['antispam'] : '' );
        update_option( 'cl_standby', isset( $_POST['standby'] ) ? $_POST['standby'] : '' );
        update_option( 'cl_hideuser', isset( $_POST['hideuser'] ) ? $_POST['hideuser'] : '' );
        update_option( 'cl_passcomplex', isset( $_POST['passcomplex'] ) ? $_POST['passcomplex'] : '' );
        update_option( 'cl_emailnotification', isset( $_POST['emailnotification'] ) ? $_POST['emailnotification'] : '' );
        update_option( 'cl_emailnotificationcontent', isset( $_POST['emailnotificationcontent'] ) ? $_POST['emailnotificationcontent'] : '' );
        update_option( 'cl_chooserole', isset( $_POST['chooserole'] ) ? $_POST['chooserole'] : '' );
        update_option( 'cl_newuserroles', isset( $_POST['newuserroles'] ) ? $_POST['newuserroles'] : '' );

        
		echo '<div class="updated"><p><strong>'. __( 'Settings saved.', 'cleanlogin' ) .'</strong></p></div>';
    }

    // Recoger las opciones del plugin
    $adminbar = get_option( 'cl_adminbar' , 'on' );
    $dashboard = get_option( 'cl_dashboard' );
    $antispam = get_option( 'cl_antispam' );
    $standby = get_option( 'cl_standby' );
    $hideuser = get_option ( 'cl_hideuser' );
    $passcomplex = get_option ( 'cl_passcomplex' );
    $emailnotification = get_option ( 'cl_emailnotification' );
    $emailnotificationcontent = get_option ( 'cl_emailnotificationcontent' );
    $chooserole = get_option ( 'cl_chooserole' );
    $newuserroles = get_option ( 'cl_newuserroles' );

    ?>
    	<form name="form1" method="post" action="">
    	<table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><?php echo __( 'Admin bar', 'cleanlogin' ); ?></th>
					<td>
						<label><input name="adminbar" type="checkbox" id="adminbar" <?php if( $adminbar == 'on' ) echo 'checked="checked"'; ?>><?php echo __( 'Hide admin bar for non-admin users?', 'cleanlogin' ); ?></label>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php echo __( 'Dashboard access', 'cleanlogin' ); ?></th>
					<td>
						<label><input name="dashboard" type="checkbox" id="dashboard" <?php if( $dashboard == 'on' ) echo 'checked="checked"'; ?>><?php echo __( 'Disable dashboard access for non-admin users?', 'cleanlogin' ); ?></label>
						<p class="description"><?php echo __( 'Please note that you can only log in through <strong>wp-login.php</strong> and this plugin. <strong>wp-admin</strong> permalink will be inaccessible.', 'cleanlogin' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php echo __( 'Antispam protection', 'cleanlogin' ); ?></th>
					<td>
						<label><input name="antispam" type="checkbox" id="antispam" <?php if( $antispam == 'on' ) echo 'checked="checked"'; ?>><?php echo __( 'Enable captcha?', 'cleanlogin' ); ?></label>
						<p class="description"><?php echo __( 'Honeypot antispam detection is enabled by default.', 'cleanlogin' ); ?></p>
						<p class="description"><?php echo __( 'For captcha usage the PHP-GD library needs to be enabled in your server/hosting.', 'cleanlogin' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php echo __( 'User role', 'cleanlogin' ); ?></th>
					<td>
						<label><input name="standby" type="checkbox" id="standby" <?php if( $standby == 'on' ) echo 'checked="checked"'; ?>><?php echo __( 'Enable Standby role?', 'cleanlogin' ); ?></label>
						<p class="description"><?php echo __( 'Standby role disables all the capabilities for new users, until the administrator changes. It usefull for site with restricted components.', 'cleanlogin' ); ?></p>
						<br>
						<label><input name="chooserole" type="checkbox" id="chooserole" <?php if( $chooserole == 'on' ) echo 'checked="checked"'; ?>><?php echo __( 'Choose the role(s) in the registration form?', 'cleanlogin' ); ?></label>
						<p class="description"><?php echo __( 'This feature allows you to choose the role from the frontend, with the selected roles you want to show. You can also define an standard predefined role through a shortcode parameter, e.g. [clean-login-register role="contributor"]. Anyway, you need to choose only the role(s) you want to accept to avoid security/infiltration issues.', 'cleanlogin' ); ?></p>
						<p>
							<select name="newuserroles[]" id="newuserroles" multiple size="5"><?php wp_dropdown_roles(); ?></select>
							<?php //print_r($newuserroles); ?>
						</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php echo __( 'Hide username', 'cleanlogin' ); ?></th>
					<td>
						<label><input name="hideuser" type="checkbox" id="hideuser" <?php if( $hideuser == 'on' ) echo 'checked="checked"'; ?>><?php echo __( 'Hide username?', 'cleanlogin' ); ?></label>
						<p class="description"><?php echo __( 'Hide username from the preview form.', 'cleanlogin' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php echo __( 'Password complexity', 'cleanlogin' ); ?></th>
					<td>
						<label><input name="passcomplex" type="checkbox" id="passcomplex" <?php if( $passcomplex == 'on' ) echo 'checked="checked"'; ?>><?php echo __( 'Enable password complexity?', 'cleanlogin' ); ?></label>
						<p class="description"><?php echo __( 'Passwords must be eight characters including one upper/lowercase letter, one special/symbol character and alphanumeric characters. Passwords should not contain the user\'s username, email, or first/last name.', 'cleanlogin' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php echo __( 'Email notification', 'cleanlogin' ); ?></th>
					<td>
						<label><input name="emailnotification" type="checkbox" id="emailnotification" <?php if( $emailnotification == 'on' ) echo 'checked="checked"'; ?>><?php echo __( 'Enable email notification for new registered users?', 'cleanlogin' ); ?></label>
						<p><textarea name="emailnotificationcontent" id="emailnotificationcontent" placeholder="<?php echo __( 'Please use HMTL tags for all formatting. And also you can use:', 'cleanlogin' ) . ' {username} {password} {email}'; ?>" rows="8" cols="50" class="large-text code"><?php echo $emailnotificationcontent; ?></textarea></p>
					</td>
				</tr>
			</tbody>
		</table>
		<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="<?php echo $hidden_field_value; ?>">

	    <p class="submit"><input type="submit" name="Submit" class="button-primary" value="<?php echo __( 'Save Changes', 'cleanlogin' ); ?>" /></p>
        </form>
    </div>
    <script>
    jQuery(document).ready(function( $ ) {

    	var selected_roles = <?php echo json_encode($newuserroles); ?>;
    	$('select#newuserroles').find('option').each(function() {
    		//alert(jQuery.inArray($(this).val(), selected_roles));
		    if( jQuery.inArray($(this).val(), selected_roles) < 0 )
		    	$(this).attr('selected', false);
		    else
		    	$(this).attr('selected', true);
		});

    	if ($('#chooserole').is(':checked')) {
            $('#newuserroles').show();
        } else {
        	$('#newuserroles').hide();
        }

    	$('#chooserole').click(function() {
	        if ($(this).is(':checked')) {
	            $('#newuserroles').show();
	        } else {
	        	$('#newuserroles').hide();
	        }
	    });

		if ($('#emailnotification').is(':checked')) {
            $('#emailnotificationcontent').show();
        } else {
        	$('#emailnotificationcontent').hide();
        }

	    $('#emailnotification').click(function() {
	        if ($(this).is(':checked')) {
	            $('#emailnotificationcontent').show();
	        } else {
	        	$('#emailnotificationcontent').hide();
	        }
	    });

	});
    </script>
	<?php
}

/*         _     __           __ 
 _      __(_)___/ /___ ____  / /_
| | /| / / / __  / __ `/ _ \/ __/
| |/ |/ / / /_/ / /_/ /  __/ /_  
|__/|__/_/\__,_/\__, /\___/\__/  
               /____/            
*/

/**
* This widget shows both the current user status and the links to access to the different pages/post which contain the shorcodes
*
* @since 1.0
*/
// Creating the widget 
class clean_login_widget extends WP_Widget {


	function __construct() {
		parent::__construct(
			'clean_login_widget', 
			'Clean Login status and links', 
			array( 'description' => __( 'Use this widget to show the user login status and Clean Login links.', 'cleanlogin' ), ) 
		);
	}

	// Frontend
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		echo $args['before_widget'];
		
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];

		$login_url = get_option( 'cl_login_url', '');
		$edit_url = get_option( 'cl_edit_url', '');
		$register_url = get_option( 'cl_register_url', '');
		$restore_url = get_option( 'cl_restore_url', '');
		// Output stars
		if ( is_user_logged_in() ) {
			global $current_user;
			get_currentuserinfo();
			echo get_avatar( $current_user->ID, 96 );
			if ( $current_user->user_firstname == '')
				echo "<h1 class='widget-title'>$current_user->user_login</h1>";
			else
				echo "<h1 class='widget-title'>$current_user->user_firstname $current_user->user_lastname</h1>";

			if ( $edit_url != '' )
				echo "<ul><li><a href='$edit_url'>". __( 'Edit my profile', 'cleanlogin') ."</a></li></ul>";

			if ( $login_url != '' )
				echo "<ul><li><a href='$login_url?action=logout'>". __( 'Logout', 'cleanlogin') ."</a></li></ul>";


		} else {
			echo "<ul>";
			if ( $login_url != '' ) echo "<li><a href='$login_url'>". __( 'Log in', 'cleanlogin') ."</a></li>";
			if ( $register_url != '' ) echo "<li><a href='$register_url'>". __( 'Register', 'cleanlogin') ."</a></li>";
			if ( $restore_url != '' )echo "<li><a href='$restore_url'>". __( 'Lost password?', 'cleanlogin') ."</a></li>";
			echo "</ul>";
		}
		// Output ends

		echo $args['after_widget'];
	}
		
	// Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) )
			$title = $instance[ 'title' ];
		else
			$title = __( 'User login status', 'cleanlogin' );
		// Widget admin form
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php __( 'Title:', 'clean-login' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php 
	}
	
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
	return $instance;
	}
}

function clean_login_load_widget() {
	register_widget( 'clean_login_widget' );
}
add_action( 'widgets_init', 'clean_login_load_widget' );

?>
