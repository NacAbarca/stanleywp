<?php

add_action('init','of_options');

if (!function_exists('of_options'))
{
	function of_options()
	{
		//Access the WordPress Categories via an Array
		$of_categories 		= array();
		$of_categories_obj 	= get_categories('hide_empty=0');
		foreach ($of_categories_obj as $of_cat) {
			$of_categories[$of_cat->cat_ID] = $of_cat->cat_name;}
			$categories_tmp 	= array_unshift($of_categories, "Select a category:");


		//Access the WordPress Pages via an Array
			$of_pages 			= array();
			$of_pages_obj 		= get_pages('sort_column=post_parent,menu_order');
			foreach ($of_pages_obj as $of_page) {
				$of_pages[$of_page->ID] = $of_page->post_name; }
				$of_pages_tmp 		= array_unshift($of_pages, "Select a page:");


		//Testing
				$of_options_select 	= array("one","two","three","four","five");
				$of_options_radio 	= array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");

				$font_size = array( 'select', '12px', '13px', '14px' );
				$font_style = array( "normal", "italic", "bold", "bold italic");

		//Sample Homepage blocks for the layout manager (sorter)
				$of_options_homepage_blocks = array(
			"enabled"	=> array (
				"placebo"	=> "placebo", //REQUIRED!
				"home_static_page"	=> "Contenido",

			),
			"disabled"	=> array (
				"placebo"	=> "placebo", //REQUIRED!
				"home_portfolio"	=> "portofolio",
			),
		);


		//Stylesheets Reader
				$alt_stylesheet_path = LAYOUT_PATH;
				$alt_stylesheets = array();

				if ( is_dir($alt_stylesheet_path) )
				{
					if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) )
					{
						while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false )
						{
							if(stristr($alt_stylesheet_file, ".css") !== false)
							{
								$alt_stylesheets[] = $alt_stylesheet_file;
							}
						}
					}
				}


		//Background Images Reader
		$bg_images_path = get_stylesheet_directory(). '/images/bg/'; // change this to where you store your bg images
		$bg_images_url = get_template_directory_uri().'/images/bg/'; // change this to where you store your bg images
		$bg_images = array();

		if ( is_dir($bg_images_path) ) {
			if ($bg_images_dir = opendir($bg_images_path) ) {
				while ( ($bg_images_file = readdir($bg_images_dir)) !== false ) {
					if(stristr($bg_images_file, ".png") !== false || stristr($bg_images_file, ".jpg") !== false) {
						$bg_images[] = $bg_images_url . $bg_images_file;
					}
				}
			}
		}


		/*-----------------------------------------------------------------------------------*/
		/* TO DO: Add options/functions that use these */
		/*-----------------------------------------------------------------------------------*/

		$menu_color = array( 'Default', 'Inverse' );
		// Homepage Latest Blog or Featured Image
		$hp_array = array('featured' => __('Unidad de Héroe Destacada', 'gents'),'latest' => __('Último artículo del blog', 'gents'));
		// Buttons
		$btn_color = array("default" => "Default Gray","primary" => "Primary","info" => "Info","success" => "Success","warning" => "Warning","danger" => "Danger","inverse" => "Inverse");
		$btn_size = array("xs" => "Extra Small","sm" => "Small","default" => "Medium","lg" => "Large");

		//More Options
		$uploads_arr 		= wp_upload_dir();
		$all_uploads_path 	= $uploads_arr['path'];
		$all_uploads 		= get_option('of_uploads');
		$other_entries 		= array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
		$body_repeat 		= array("no-repeat","repeat-x","repeat-y","repeat");
		$body_pos 			= array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");

		// Image Alignment radio box
		$of_options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center");

		// Image Links to Options
		$of_options_image_link_to = array("image" => "The Image","post" => "The Post");


		/*-----------------------------------------------------------------------------------*/
		/* The Options Array */
		/*-----------------------------------------------------------------------------------*/

// Set the Options Array
		global $of_options;
		$of_options = array();

		$of_options[] = array( "name"	=> __( 'General', 'gents' ),
			"type"	=> "heading",
			);

		$of_options[] = array( "name"	=> __( 'Favicon', 'gents' ),
			"desc"	=> __( 'Cargue o pegue la URL de su favicon personalizado.', 'gents' ),
			"id"	=> "custom_favicon",
			"std"	=> "",
			"type"	=> "media");

		// Header
		$of_options[] = array( "name"	=> __( 'Encabezamiento', 'gents' ),
			"type"	=> "heading");


		$of_options[] = array( "name"	=> __( 'Logo principal', 'gents' ),
			"desc"	=> __( 'Use este campo para cargar su logotipo personalizado para usar en el encabezado del tema. (Recomendado 200px x 40px)', 'gents' ),
			"id"	=> "custom_logo",
			"std"	=> "",
			"type"	=> "media",
			);


		//Homepage
		$of_options[] = array( "name"	=> __( 'Página principal', 'gents' ),
			"type"	=> "heading");

		$of_options[] = array( "name"	=> __( 'Administrador de diseño de la página de inicio', 'gents' ),
			"desc"	=> __( 'Organice cómo quiere que el diseño aparezca en la página de inicio.', 'gents' ),
			"id"	=> "homepage_blocks",
			"std"	=> $of_options_homepage_blocks,
			"type"	=> "sorter");


		$of_options[] = array( 	"name"	=> "",
							"desc"	=> "",
							"id"	=> "subheading",
							"std"	=> "<h3 style=\"margin: 0;\">". __( 'portofolio', 'gents' ) ."</h3>",
							"icon"	=> true,
							"type"	=> "info"
					);


			$of_options[] = array( "name"	=> __( 'Artículos de portofolio', 'gents' ),
							"desc"	=> __( 'Ingrese la cantidad de elementos del portofolio para mostrar en la página de inicio. -1 para todos los artículos.', 'gents' ),
							"id"	=> "home_portfolio_count",
							"std"	=> "3",
							"type"	=> "text");

				//Blog
		$of_options[] = array( "name"	=> __( 'Blog', 'gents' ),
			"type"	=> "heading");


		$of_options[] = array( 	"name" 		=> "Texto: Leer más ",
			"desc" 		=> "Este es el texto que reemplazará a Leer más.",
			"id" 		=> "read_more_text",
			"std" 		=> "Read More",
			"type" 		=> "text"
			);


		$of_options[] = array( "name"	=> __( 'Mostrar etiquetas', 'gents' ),
			"desc"	=> __( 'Seleccione para habilitar / deshabilitar las etiquetas de publicación.', 'gents' ),
			"id"	=> "enable_disable_tags",
			"std"	=> '1',
			"on"	=> __( 'Habilitar', 'gents' ),
			"off"	=> __( 'Inhabilitar', 'gents' ),
			"type"	=> "switch");


			//Portfolio
		$of_options[] = array( "name"	=> __( 'portofolio', 'gents' ),
			"type"	=> "heading");



		$of_options[] = array( "name"	=> __( 'Mostrar títulos de proyectos', 'gents' ),
			"desc"	=> __( 'Seleccionar para habilitar / deshabilitar los títulos del proyecto.', 'gents' ),
			"id"	=> "project_title",
			"std"	=> '1',
			"on"	=> __( 'Habilitar', 'gents' ),
			"off"	=> __( 'Inhabilitar', 'gents' ),
			"type"	=> "switch");


		//Post Types
		$of_options[] = array( "name"	=> __( 'Post Types', 'reponsive' ),
							"type"	=> "heading");


		$of_options[] = array( "name"	=> __( 'Nombre de la portofolio', 'reponsive' ),
							"desc"	=> __( 'Ingrese un nombre personalizado para su tipo de publicación de portofolio.', 'reponsive' ),
							"id"	=> "portfolio_post_type_name",
							"std"	=> "Portfolio",
							"type"	=> "text");

		$of_options[] = array( "name"	=> __( 'portofolio Slug', 'reponsive' ),
							"desc"	=> __( 'Ingrese un slug personalizado para su tipo de publicación de cartera. Ve <strong> guarda tus enlaces permanentes </strong> después de cambiar esto.', 'reponsive' ),
							"id"	=> "portfolio_post_type_slug",
							"std"	=> "portfolio",
							"type"	=> "text");


		$of_options[] = array( "name"	=> __( 'Seguimiento', 'gents' ),
			"type"	=> "heading");

		$of_options[] = array( "name"	=> __( 'Código de seguimiento del encabezado', 'gents' ),
			"desc"	=> __( 'Pegue aquí su código de seguimiento de Google Analytics (u otro). Esto se agregará a la plantilla de encabezado de tu tema.', 'gents' ),
			"id"	=> "tracking_header",
			"std"	=> "",
			"type"	=> "textarea");

		$of_options[] = array( "name"	=> __( 'Código de seguimiento de pie de página', 'gents' ),
			"desc"	=> __( 'Pegue aquí su código de seguimiento de Google Analytics (u otro). Esto se agregará a la plantilla de pie de página de su tema.', 'gents' ),
			"id"	=> "tracking_footer",
			"std"	=> "",
			"type"	=> "textarea");

		//Custom CSS
		$of_options[] = array( "name"	=> __( 'CSS personalizado', 'gents' ),
			"type"	=> "heading");

		$of_options[] = array( "name"	=> __( 'CSS personalizado', 'gents' ),
			"desc"	=> __( 'Agregue rápidamente algo de CSS a su tema agregándolo a este bloque.', 'gents' ),
			"id"	=> "custom_css_box",
			"std"	=> "",
			"type"	=> "textarea");

	// Backup Options
		$of_options[] = array( 	"name" 		=> "Opciones de respaldo",
			"type" 		=> "heading",
			);

		$of_options[] = array( 	"name" 		=> "Opciones de copia de seguridad y restauración",
			"id" 		=> "of_backup",
			"std" 		=> "",
			"type" 		=> "backup",
			"desc" 		=> 'Puede usar los dos botones a continuación para hacer una copia de seguridad de sus opciones actuales y luego restaurarlas en otro momento. Esto es útil si desea experimentar con las opciones, pero le gustaría mantener la configuración anterior en caso de que la necesite.',
			);

		$of_options[] = array( 	"name" 		=> "Transferir datos de opciones de tema",
			"id" 		=> "of_transfer",
			"std" 		=> "",
			"type" 		=> "transfer",
			"desc" 		=> 'Puede transferir los datos de las opciones guardadas entre diferentes instalaciones copiando el texto dentro del cuadro de texto. Para importar datos desde otra instalación, reemplace los datos en el cuadro de texto con el de otra instalación y haga clic en "Importar opciones".',
			);

	}//End function: of_options()
}//End chack if function exists: of_options()
?>
