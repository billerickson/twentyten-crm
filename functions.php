<?php
function twentyten_setup() {
	// Copied and modified from twentyten/functions.php.	
		
	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails');

	register_nav_menus( array(
		'top-panel-1' => __( 'Top Panel - At a Glance', 'twentyten' ),
		'top-panel-2' => __( 'Top Panel - Admin', 'twentyten' ),
		'primary' => __( 'Primary Navigation', 'twentyten' ),
		'footer' => __( 'Footer Navigation', 'twentyten' ),
	) );
	
	function crm_nav_menus_fallback() {
		// do nothing!
	}
	
	function crm_nav_top1_fallback() {
		echo '<ul>';
        echo '<li><a href="' . get_option( 'home' ) . '/active-projects/">Active Projects</a></li>';
        echo '<li><a href="' . get_option( 'home' ) . '/prospects/">Prospects</a></li>';
		echo '<li><a href="' . get_option( 'home' ) . '/download/">Download</a></li>';
        echo '</ul>';
	}
	
	function crm_nav_top2_fallback() {
		echo '<ul>';
        echo '<li><a href="' . get_option( 'home' ) . '/wp-admin/post-new.php">Add New Contact</a></li>';
        echo '<li><a href="' . wp_logout_url( get_bloginfo('url') ) . '" title="Logout">Logout</a></li>';
		echo '<li><a href="' . get_option( 'home' ) . '/">Dashboard Home</a></li>';
        echo '</ul>';
	}
	
	// Setup Sidebars
	remove_action( 'widgets_init', 'twentyten_widgets_init' );
	add_action( 'widgets_init', 'crm_widgets_init' );

	function crm_widgets_init() {
		register_sidebar( array(
			'name' => 'Home Column 1',
			'id' => 'home-column-1',
			'description' => 'Left side of Homepage',
			'before_widget' => '<div class="home-widget">',
			'after_widget' => '</div>',
			'before_title' => '<h2>',
			'after_title' => '</h2>',
		) );
		register_sidebar( array(
			'name' => 'Home Column 2',
			'id' => 'home-column-2',
			'description' => 'Middle of Homepage',
			'before_widget' => '<div class="home-widget">',
			'after_widget' => '</div>',
			'before_title' => '<h2>',
			'after_title' => '</h2>',
		) );
		register_sidebar( array(
			'name' => 'Home Column 3',
			'id' => 'home-column-3',
			'description' => 'Right side of Homepage',
			'before_widget' => '<div class="home-widget">',
			'after_widget' => '</div>',
			'before_title' => '<h2>',
			'after_title' => '</h2>',
		) );
		register_sidebar( array(
			'name' => 'Footer',
			'id' => 'footer-widgets',
			'description' => 'Displays 4 widgets per row of the footer',
			'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
			'after_widget' => '</li>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
	
		unregister_sidebar( 'primary-widget-area' );
		unregister_sidebar( 'secondary-widget-area' );
		unregister_sidebar( 'first-footer-widget-area' );
		unregister_sidebar( 'second-footer-widget-area' );
		unregister_sidebar( 'third-footer-widget-area' );
		unregister_sidebar( 'fourth-footer-widget-area' );
	}	

}

/*-----------------------------------------------------------------------------------*/
/* Back End */
/*-----------------------------------------------------------------------------------*/
// Register Taxonomies
add_action( 'init', 'crm_create_my_taxonomies', 0 );
function crm_create_my_taxonomies() {
	register_taxonomy( 
		'poc', 
		'post', 
		array( 
			'hierarchical' => true, 
			'labels' => array(
				'name' => 'Points of Contact',
				'singlular_name' => 'Point of Contact'
			),
			'query_var' => true, 
			'rewrite' => true 
		) 
	);
	register_taxonomy( 
		'sources', 
		'post', 
		array( 
			'hierarchical' => true, 
			'labels' => array(
				'name' => 'Sources',
				'singlular_name' => 'Source'
			),
			'query_var' => true, 
			'rewrite' => true 
		) 
	);		
}
	
// Custom Meta Boxes
//// Setup Meta Box Data
global $prefix;
$prefix = 'crm_';
$meta_boxes = array();

$meta_boxes[] = array(
    'id' => 'client_information',
    'title' => 'Client Information',
    'pages' => array('post'), // post type
	'context' => 'normal',
	'priority' => 'high',
	'show_names' => true, // Show field names left of input
    'fields' => array(
        array(
            'name' => 'Client Email',
            'id' => $prefix.'client_email',
            'desc' => 'Client Email',
            'type' => 'text',
        ),
        array(
            'name' => 'Client Phone',
            'id' => $prefix.'client_phone',
            'desc' => 'Client Phone',
            'type' => 'text',
        ),
        array(
            'name' => 'Client URL',
            'id' => $prefix.'client_url',
            'desc' => 'Client URL',
            'type' => 'text',
        ),
        array(
            'name' => 'Other Referral',
            'id' => $prefix.'other_referral',
            'desc' => 'Other Referral Source',
            'type' => 'text',
        )
    )
);

$meta_boxes[] = array(
    'id' => 'project_information',
    'title' => 'Project Information',
    'pages' => array('post'), // post type
	'context' => 'normal',
	'priority' => 'high',
	'show_names' => true, // Show field names left of input
    'fields' => array(
        array(
            'name' => 'Project Status',
            'id' => $prefix.'project_status',
            'type' => 'radio_inline',
            'options' => array(
            	array('name' => 'In Progress', 'value' => 'in progress'),
            	array('name' => 'No Response', 'value' => 'no response'),
            	array('name' => 'Forwarded Away', 'value' => 'forwarded away'),
            	array('name' => 'Quoted and Lost', 'value' => 'quoted and lost'),
            	array('name' => 'Quoted and Won', 'value' => 'quoted and won')
            )
        ),
        array(
            'name' => 'Status Summary',
            'id' => $prefix.'status_summary',
            'type' => 'text',
        ),
        array(
        	'name' => 'Action Item',
        	'id' => $prefix.'actionitem', 
        	'type' => 'select',
        	'options' => array(
        		array('name' => '', 'value' => ''),
        		array('name' => 'Awaiting Start Date', 'value' => 'awaiting start date'),
        		array('name' => 'Awaiting Client Approval', 'value' => 'awaiting approval'),
        		array('name' => 'Sending Contract', 'value' => 'sending contract'),
        		array('name' => 'Sending Deposit Invoice', 'value' => 'sending deposit invoice'),
        		array('name' => 'Awaiting Content', 'value' => 'awaiting content'),
        	)
        ),
        array(
        	'name' => 'Reason',
        	'id' => $prefix.'reason', 
        	'type' => 'select',
        	'options' => array(
        		array('name' => '', 'value' => ''),
				array('name' => 'accepted project', 'value' => 'accepted project'),
        		array('name' => 'project too small', 'value' => 'project too small'),
        		array('name' => 'not interested', 'value' => 'not interested'),
        		array('name' => 'outside expertise', 'value' => 'outside expertise'),
        		array('name' => 'timeframe too short', 'value' => 'timeframe too short')
        	)
        ),
        array(
        	'name' => 'Revenue',
        	'id' => $prefix.'revenue',
        	'type' => 'text_money',
        ),
        array(
        	'name' => 'Expense',
        	'id' => $prefix.'expense',
        	'type' => 'text_money',
        ),
        array(
        	'name' => 'Start Date',
        	'id' => $prefix.'start_date',
        	'desc' => 'Start Date (YYYY-MM-DD)',
        	'type' => 'text_date',	
        ),
        array(
        	'name' => 'End Date',
        	'id' => $prefix.'end_date',
        	'desc' => 'End Date (YYYY-MM-DD)',
        	'type' => 'text_date',
        ),
        array(
        	'name' => 'File Upload',
        	'id' => $prefix.'img_upload',
        	'desc' => 'Attach files',
        	'type' => 'file_list',
        ),							
    )
);

//-- Begin moving post editor to notes metabox ---------
//  Comment this out to disable
$meta_boxes[] = array(
    'id' => 'crm_notes',
    'title' => 'Notes',
    'pages' => array('post'), // post type
	'context' => 'normal',
	'priority' => 'high',
	'show_names' => false, // Show field names left of input
    'fields' => array()
);

function crm_move_posteditor( $hook ) {
  	if ( $hook == 'post.php' OR $hook == 'post-new.php' ) {
		wp_enqueue_script( 'jquery' );
		add_action('admin_print_footer_scripts','crm_move_posteditor_scripts');
  	}
}
add_action( 'admin_enqueue_scripts', 'crm_move_posteditor', 10, 1 );

function crm_move_posteditor_scripts() {
	?>
	<script type="text/javascript">
		jQuery('#postdiv, #postdivrich').prependTo('#crm_notes .inside');
	</script>
	<style type="text/css">
			#normal-sortables {margin-top: 20px;}
			#titlediv { margin-bottom: 0px; }
			#postdiv.postarea, #postdivrich.postarea { margin:0; }
			#post-status-info { line-height:1.4em; font-size:13px; }
			#custom_editor .inside { margin:2px 6px 6px 6px; }
			#ed_toolbar { display:none; }
			#postdiv #ed_toolbar, #postdivrich #ed_toolbar { display:block; }
	</style>
	<?php
}
//-- End moving post editor
	
// Create Meta Box
include_once( 'lib/metabox/init.php' );

// Add ability to upload Adobe files (photoshop, etc)
// MIME types found at http://www.webmaster-toolkit.com/mime-types.shtml
function crm_add_upload_support( $mimes ) {
	$mimes['psd']	= 'application/psd';
	$mimes['eps']	= 'application/postscript';
	$mimes['ai']	= 'application/postscript';
	return $mimes;
}
add_filter( 'upload_mimes','crm_add_upload_support' );

// Change the labeling for the "Posts" menu to "Contacts"
add_action( 'init', 'crm_change_post_object_label' );
add_action( 'admin_menu', 'crm_change_post_menu_label' );

function crm_change_post_menu_label() {
	global $menu;
	global $submenu;
	$menu[5][0] = 'Contacts';
	$menu[10][0] = 'Files';	
	$submenu['edit.php'][5][0] = 'Contacts';
	$submenu['edit.php'][10][0] = 'Add Contacts';
	$submenu['edit.php'][15][0] = 'Status';
	echo '';
}

function crm_change_post_object_label() {
	global $wp_post_types;
	$labels = &$wp_post_types['post']->labels;
	$labels->name = 'Contacts';
	$labels->singular_name = 'Contact';
	$labels->add_new = 'Add Contact';
	$labels->add_new_item = 'Add Contact';
	$labels->edit_item = 'Edit Contacts';
	$labels->new_item = 'Contact';
	$labels->view_item = 'View Contact';
	$labels->search_items = 'Search Contacts';
	$labels->not_found = 'No Contacts found';
	$labels->not_found_in_trash = 'No Contacts found in Trash';
}

// Remove dashboard widgets
add_action( 'admin_menu', 'crm_remove_dashboard_boxes' );
function crm_remove_dashboard_boxes() {
	remove_meta_box( 'dashboard_right_now', 'dashboard', 'core' );
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'core' );
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'core' );
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'core' );
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'core' );
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'core' );
	remove_meta_box( 'dashboard_primary', 'dashboard', 'core' );
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'core' );
}

// Add Dashboard Widgets
add_action( 'wp_dashboard_setup', 'crm_custom_dashboard_widgets' );
function crm_custom_dashboard_widgets() {
	wp_add_dashboard_widget('custom_help_widget', 'TwentyTen CRM', 'crm_dashboard_help');
}

//// New Dashboard Widget (we'll figure out what to do with this later)
 function crm_dashboard_help() {
    echo '<p>Welcome to the '.get_bloginfo('name').' dashboard panel</p>';
}

// Change source directory for icons
add_filter( 'icon_dir_uri', 'crm_icon_uri' );
function crm_icon_uri( $icon_dir ) {
	return get_bloginfo('stylesheet_directory').'/images'; 
}

// Change post title text
add_action( 'gettext', 'crm_change_title_text' );
function crm_change_title_text( $translation ) {
	global $post;
	if( isset( $post ) ) {
		switch( $post->post_type ){
			case 'post' :
				if( $translation == 'Enter title here' ) return 'Enter Contact Name Here';
			break;
		}
	}
	return $translation;
}

// Modify post column layout
add_filter( 'manage_posts_columns', 'crm_add_new_columns' );
function crm_add_new_columns( $crm_columns ) {
	$new_columns['cb'] = '<input type="checkbox" />';
	$new_columns['title'] = _x('Contact Name', 'column name');
	$new_columns['status'] = __('Status');	
	$new_columns['poc'] = __('Point Of Contact');
	$new_columns['source'] = __('Source');		
	$new_columns['date'] = _x('Date', 'column name');
	return $new_columns;
}

// Add taxonomies to post column
add_action( 'manage_posts_custom_column', 'crm_manage_columns', 10, 2 );
function crm_manage_columns ($column_name, $id ) {
	global $post;
	switch ($column_name) {
		case 'status':
			$category = get_the_category(); 
			echo $category[0]->cat_name;
	    	    break;
		case 'poc':
			echo get_the_term_list( $post->ID, 'poc', '', ', ', '');
		        break;
 		case 'source':
			echo get_the_term_list( $post->ID, 'sources', '', ', ', '');
		        break;
		default:
			break;
	} // end switch
}

// Remove admin sidebar items
add_action( 'admin_menu', 'crm_remove_admin_menu_items' );  
function crm_remove_admin_menu_items() {
 	$remove_menu_items = array(__('Links'),__('Comments'));
	global $menu;
	end ($menu);
	while (prev($menu)){
		$item = explode(' ',$menu[key($menu)][0]);
		if(in_array($item[0] != NULL?$item[0]:"" , $remove_menu_items)){
			unset($menu[key($menu)]);
		}
	}
}

//add_action('admin_print_styles', 'crm_shrink_sidebar_items');
function crm_shrink_sidebar_items() {
	?>
	<style type="text/css">
	.categorydiv div.tabs-panel, .customlinkdiv div.tabs-panel, .posttypediv div.tabs-panel, .taxonomydiv div.tabs-panel, #linkcategorydiv div.tabs-panel {
	    height: 80px !important;
	}
	</style>
	<?php
}

// Remove tags
add_action( 'admin_menu', 'crm_remove_submenus' );
function crm_remove_submenus() {
  global $submenu;
  unset( $submenu['edit.php'][16] ); // Removes 'Tags'.  
}

// Customize Admin Menu Order
add_filter( 'custom_menu_order', 'crm_custom_menu_order' );
add_filter( 'menu_order', 'crm_custom_menu_order' );
function crm_custom_menu_order( $menu_ord ) {
	if ( !$menu_ord ) return true;
	return array(
		'index.php', // this represents the dashboard link
		'edit.php', //the posts tab
		'upload.php', // the media manager
		'edit.php?post_type=page', //the posts tab
    );
}

// Remove post meta fields
add_action( 'admin_menu' , 'crm_remove_page_fields' );
function crm_remove_page_fields() {
	remove_meta_box( 'commentstatusdiv' , 'post' , 'normal' ); //removes comments status
	remove_meta_box( 'commentsdiv' , 'post' , 'normal' ); //removes comments
	remove_meta_box( 'postexcerpt' , 'post' , 'normal' );
	remove_meta_box( 'trackbacksdiv' , 'post' , 'normal' );
	remove_meta_box( 'authordiv' , 'post' , 'normal' );
	remove_meta_box( 'postcustom' , 'post' , 'normal' );
	remove_meta_box( 'revisionsdiv'	, 'post' , 'normal' );
	remove_meta_box( 'tagsdiv-post_tag', 'post', 'normal' );
}

// Remove sidebar widgets
add_action( 'widgets_init', 'crm_remove_widgets', 1 );
function crm_remove_widgets(){
	//unregister_widget('WP_Widget_Pages');
	//unregister_widget('WP_Widget_Calendar');
	unregister_widget('WP_Widget_Archives');
	unregister_widget('WP_Widget_Links');
	//unregister_widget('WP_Widget_Meta');
	//unregister_widget('WP_Widget_Search');
	unregister_widget('WP_Widget_Categories');
	//unregister_widget('WP_Widget_Recent_Posts');
	//unregister_widget('WP_Widget_Recent_Comments');
	unregister_widget('WP_Widget_RSS');
	unregister_widget('WP_Widget_Tag_Cloud');
}

// Include our widgets
add_action( 'after_setup_theme', 'crm_add_widgets' );
function crm_add_widgets() {
	include_once( 'lib/widgets/widget-old-prospects.php' );
	include_once( 'lib/widgets/widget-active-projects.php' );
	include_once( 'lib/widgets/widget-other-stats.php' );
	include_once( 'lib/widgets/widget-poc.php' );
	include_once( 'lib/widgets/widget-inquiry.php' );
	include_once( 'lib/widgets/widget-inquiry-result.php' );
	include_once( 'lib/widgets/widget-forwarded.php' );
	include_once( 'lib/widgets/widget-project-sources.php' );
	include_once( 'lib/widgets/widget-referral.php' );
	include_once( 'lib/widgets/widget-activity-graph.php' );
}

// Remove Header bloat
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'parent_post_rel_link' );
remove_action( 'wp_head', 'start_post_rel_link' );
remove_action( 'wp_head', 'adjacent_posts_rel_link' );


/*-----------------------------------------------------------------------------------*/
/* Front End */
/*-----------------------------------------------------------------------------------*/

// Load jQuery & top panel
if ( !is_admin() ) {
	wp_deregister_script('jquery');
	wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"), false);
	wp_enqueue_script('jquery');
	wp_register_script('crm-slide', get_bloginfo('stylesheet_directory').'/lib/js/slide.js');
	wp_enqueue_script('crm-slide');
}
	
// TwentyTen CRM Documentation
add_action( 'twentyten_credits', 'crm_documentation' );
function crm_documentation() {
	echo '<a class="documentation" href="http://www.billerickson.net/twentyten-crm" target="_blank">TwentyTen CRM Documentation</a>';
}

// Top Panel instead of Admin Bar
// ** If you want to use the Admin Bar instead of the Top Panel, uncomment the three lines below **//
add_filter( 'show_admin_bar', '__return_false' );
remove_action( 'personal_options', '_admin_bar_preferences' );
add_action('wp_rotator_top', 'wp_rotator_top_panel');

function wp_rotator_top_panel() {
	include('top-panel.php');
}


/*-----------------------------------------------------------------------------------*/
/* Used in other template files */
/*-----------------------------------------------------------------------------------*/

/* Percent Function */
function crm_percent($num_amount, $num_total) {
	$count1 = $num_amount / $num_total;
	$count2 = $count1 * 100;
	$count = number_format($count2, 0);
	return $count.'%';
}

/* Get Post Meta Shorthand */
function get_custom_field($field) {
	global $post;
	$value = get_post_meta($post->ID, $field, true);
	if ($value) return esc_attr( $value );
	else return false;
}