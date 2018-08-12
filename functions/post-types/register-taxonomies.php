<?php
/**
 * Registers custom taxomies for use with this theme
 *
 * @package WordPress
*/

add_action( 'init', 'bi_register_taxonomies' );

if ( !function_exists('bi_register_taxonomies') ) {

	function bi_register_taxonomies() {

		//portfolio
		$portfolio_post_type_name = bi_get_data('portfolio_post_type_name') ? bi_get_data('portfolio_post_type_name') : __('Portfolio','gents');
		$portfolio_tax_slug = bi_get_data('portfolio_tax_slug') ? bi_get_data('portfolio_tax_slug') : 'portfolio-category';

			// Portfolio taxonomies
		register_taxonomy('portfolio_cats','portfolio',array(
			'hierarchical' => true,
			'labels' => apply_filters('bi_portfolio_tax_labels', array(
				'name' => $portfolio_post_type_name . ' ' . __( 'Categorias', 'gents' ),
				'singular_name' => $portfolio_post_type_name . ' '. __( 'Categoría', 'gents' ),
				'search_items' =>  __( 'Buscar Categorías', 'gents' ),
				'all_items' => __( 'Todas las categorias', 'gents' ),
				'parent_item' => __( 'Categoría principal', 'gents' ),
				'parent_item_colon' => __( 'Categoria principal:', 'gents' ),
				'edit_item' => __( 'Editar Categoría', 'gents' ),
				'update_item' => __( 'Categoría de actualización', 'gents' ),
				'add_new_item' => __( 'Añadir nueva categoria', 'gents' ),
				'new_item_name' => __( 'Nuevo nombre de categoría', 'gents' ),
				'choose_from_most_used'	=> __( 'Elija de las categorías más usadas', 'gents' )
				)
			),
			'query_var' => true,
			'rewrite' => array( 'slug' => $portfolio_tax_slug ),
		));


	}

} ?>
