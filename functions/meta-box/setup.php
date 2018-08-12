<?php
/**
 * Registering meta boxes
 *
 * All the definitions of meta boxes are listed below with comments.
 * Please read them CAREFULLY.
 *
 * You also should read the changelog to know what has been changed before updating.
 *
 * For more information, please visit:
 * @link http://www.deluxeblogtips.com/meta-box/
 */

/********************* META BOX DEFINITIONS ***********************/

/**
 * Prefix of meta keys (optional)
 * Use underscore (_) at the beginning to make keys hidden
 * Alt.: You also can make prefix empty to disable it
 */
// Better has an underscore as last sign
$prefix = 'wtf_';

global $meta_boxes;

$meta_boxes = array();

// Post Type name
	$portfolio_post_type_name = ( bi_get_data('portfolio_post_type_name') ) ? bi_get_data('portfolio_post_type_name') : __('Portfolio','gents');

	//Individual Portfolio
	$meta_boxes[] = array(
		'id'         => 'portfolio_metabox',
		'title'      => 'Opciones',
		'pages'      => array( 'portfolio', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true,
		'fields'     => array(
			array(
				'name' => __('Titulo principal','gents'),
				'desc' => __('Este es el contenido que se mostrará en la parte superior. (Opcional)','gents'),
				'id' => $prefix . 'portfolio_top_title',
				'type' => 'textarea',
				'cols' => 20,
				'rows' => 3,
				'std' => '<h3>NOMBRE DEL PROYECTO</h3>',
			),
			array(
				'name'    => __( 'Mostrar categorías', 'gents' ),
				'id'      => $prefix . 'port_cats',
				'type'    => 'radio',
				'options' => array(
					'value1' => __( 'Si', 'gents' ),
					'value2' => __( 'No', 'gents' ),
				),
			),
			array(
				'name' => __( 'Imágenes', 'gents' ),
				'id'   => "thickbox",
				'type' => 'thickbox_image',
			),

		),
	);


	// Portfolio Page
$meta_boxes[] = array(
	'title'  => __( 'Opciones', 'gents' ),
	'pages' => array('page'),
	'fields' => array(
			array(
				'name' => __('Título','gents'),
				'desc' => __('Ingrese el texto que se mostrará encima de los portofolios de la cartera. ','gents'),
				'id' => $prefix . 'portfolio_title',
				'type' => 'textarea',
				'cols' => 20,
				'rows' => 3,
				'std'  => '<h3>ÚLTIMAS OBRAS</h3>',
			),

	),
	'only_on'    => array(
		'template' => array( 'template-portfolio.php' )
	),
);


// About
$meta_boxes[] = array(
	'title'  => __( 'Opciones', 'gents' ),
	'pages' => array('page'),
	'fields' => array(
			array(
				'name' => __('Título','gents'),
				'desc' => __('Ingrese el texto que se mostrará sobre el contenido principal. ','gents'),
				'id' => $prefix . 'about_title',
				'type' => 'textarea',
				'cols' => 20,
				'rows' => 3,
				'std'  => '<h1>¡Sobre Stanley!</h1>',
			),

			array(
				'name' => __('Texto izquierdo','gents'),
				'desc' => __('Ingrese el texto que se mostrará debajo de las columnas de la izquierda. (Opcional)','gents'),
				'id' => $prefix . 'about_left_txt',
				'type' => 'textarea',
				'cols' => 20,
				'rows' => 3,
				'std'  => '<h4>EL PENSAMIENTO</h4>
				<p>Contrario a la creencia popular, Lorem Ipsum no es simplemente texto aleatorio. Tiene sus raíces en una pieza de literatura latina clásica del año 45 aC, lo que hace más de 2000 años. Richard McClintock, un profesor de latín en Hampden-Sydney College en Virginia, buscó una de las palabras latinas más oscuras, consectetur, de un pasaje de Lorem Ipsum, y pasando por las citas de la palabra en la literatura clásica, descubrió la fuente indudable.</p>',
			),

			array(
				'name' => __('Texto derecha','gents'),
				'desc' => __('Ingrese el texto que se mostrará debajo de las columnas a la derecha. (Opcional)','gents'),
				'id' => $prefix . 'about_right_txt',
				'type' => 'textarea',
				'cols' => 20,
				'rows' => 3,
				'std'  => '<h4>LAS HABILIDADES</h4>
				Wordpress
				<div class="progress">
					<div class="progress-bar progress-bar-theme" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
						<span class="sr-only">60% Completar</span>
					</div>
				</div>

				Photoshop
				<div class="progress">
					<div class="progress-bar progress-bar-theme" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
						<span class="sr-only">80% Completar</span>
					</div>
				</div>

				HTML + CSS
				<div class="progress">
					<div class="progress-bar progress-bar-theme" role="progressbar" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
						<span class="sr-only">95% Completar</span>
					</div>
				</div>',
			),


			array(
				'name' => __('Contenido de columna','gents'),
				'desc' => __('Ingrese el texto que se mostrará. (Opcional)','gents'),
				'id' => $prefix . 'about_col',
				'type' => 'textarea',
				'cols' => 20,
				'rows' => 3,
				'clone' => true,
			),

	),
	'only_on'    => array(
		'template' => array( 'template-about.php' )
	),
);


/********************* META BOX REGISTERING ***********************/

/**
 * Register meta boxes
 *
 * @return void
 */
function wtf_register_meta_boxes()
{
	global $meta_boxes;

	// Make sure there's no errors when the plugin is deactivated or during upgrade
	if ( class_exists( 'RW_Meta_Box' ) ) {
		foreach ( $meta_boxes as $meta_box ) {
			if ( isset( $meta_box['only_on'] ) && ! rw_maybe_include( $meta_box['only_on'] ) ) {
				continue;
			}

			new RW_Meta_Box( $meta_box );
		}
	}
}
// Hook to 'admin_init' to make sure the meta box class is loaded before
// (in case using the meta box class in another plugin)
// This is also helpful for some conditionals like checking page template, categories, etc.
add_action( 'admin_init', 'wtf_register_meta_boxes' );

/**
 * Check if meta boxes is included
 *
 * @return bool
 */
function rw_maybe_include( $conditions ) {
	// Include in back-end only
	if ( ! defined( 'WP_ADMIN' ) || ! WP_ADMIN ) {
		return false;
	}

	// Always include for ajax
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		return true;
	}

	if ( isset( $_GET['post'] ) ) {
		$post_id = $_GET['post'];
	}
	elseif ( isset( $_POST['post_ID'] ) ) {
		$post_id = $_POST['post_ID'];
	}
	else {
		$post_id = false;
	}

	$post_id = (int) $post_id;
	$post    = get_post( $post_id );

	foreach ( $conditions as $cond => $v ) {
		// Catch non-arrays too
		if ( ! is_array( $v ) ) {
			$v = array( $v );
		}

		switch ( $cond ) {
			case 'id':
				if ( in_array( $post_id, $v ) ) {
					return true;
				}
			break;
			case 'parent':
				$post_parent = $post->post_parent;
				if ( in_array( $post_parent, $v ) ) {
					return true;
				}
			break;
			case 'slug':
				$post_slug = $post->post_name;
				if ( in_array( $post_slug, $v ) ) {
					return true;
				}
			break;
			case 'template':
				$template = get_post_meta( $post_id, '_wp_page_template', true );
				if ( in_array( $template, $v ) ) {
					return true;
				}
			break;
		}
	}

	// If no condition matched
	return false;
}
?>
