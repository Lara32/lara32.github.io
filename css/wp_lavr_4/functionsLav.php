<?php

	include_once(__DIR__ . '/inc/test-recent-posts.php');

	add_filter('show_admin_bar', '__return_false');

	add_action('wp_enqueue_scripts', 'test_media');
	add_action('after_setup_theme', 'test_after_setup');
	add_action('widgets_init', 'test_widgets'); 
	
	add_filter('widget_text', 'do_shortcode');
	add_shortcode('test_recent', 'test_recent');
	
	add_action('init', 'test_post_types');
	
	add_filter('pre_get_document_title', function($t){
		if(is_single()){
			$t = CFS()->get('doc_title');
		}
		
		return $t;
	});
	
	add_filter('document_title_parts', function($parts){
		$parts['tagline'] .= '!';
		return $parts;
	});
	
	add_filter('document_title_separator', function($sep){
		return '|';
	});
	
	add_filter('the_content', function($content){
		return str_replace('-[]-', '!!!', $content);
	});
	
	function test_media(){
		wp_enqueue_style('test-owl', get_template_directory_uri() . '/assets/css/owl.carousel.min.css');
		wp_enqueue_style('test-owl-theme', get_template_directory_uri() . '/assets/css/owl.theme.default.min.css');
		wp_enqueue_style('test-main', get_stylesheet_uri());

		wp_enqueue_script('test-script-jquery', get_template_directory_uri() . '/assets/js/jquery-3.2.0.min.js');
		wp_enqueue_script('test-script-owl', get_template_directory_uri() . '/assets/js/owl.carousel.min.js');
		wp_enqueue_script('test-script-main', get_template_directory_uri() . '/assets/js/script.js');
	}
	
	function test_after_setup(){
		register_nav_menu('top', 'Для шапки');
		register_nav_menu('footer', 'Для подвала');
		
		add_theme_support('post-thumbnails');
		add_theme_support('title-tag');
		add_theme_support('post-formats', array('aside', 'quote'));
	}
	
	function test_widgets(){
		register_sidebar([
			'name' => 'Sidebar Right',
			'id' => 'sidebar-right',
			'description' => 'Правая колонка',
			'before_widget' => '<div class="widget %2$s">',
			'after_widget'  => "</div>\n"
		]);
		
		register_sidebar([
			'name' => 'Sidebar Top',
			'id' => 'sidebar-top',
			'description' => 'Странный пример',
			'before_widget' => '<div class="widget %2$s">',
			'after_widget'  => "</div>\n"
		]);
		
		register_widget('Test_Recent_Posts'); // регистрация виджета последних постов
	}
	
	function test_recent($atts){
		$atts = shortcode_atts( array(
			'cnt' => 5
		), $atts );
		
		$str = '';
		
		$args = array(
			'numberposts' => $atts['cnt'],
			'orderby'     => 'date',
			'order'       => 'DESC',
			'post_type'   => 'post'
		);

		$posts = get_posts($args);
		global $post;
	
		foreach($posts as $post){ 
			setup_postdata($post);
			
			$link = get_the_permalink();
			$title = get_the_title();
			$dt = get_the_date();
			$intro = CFS()->get('intro');
			
			$str .= "<div>
						<div><em>$dt</em></div>
						<div><strong>$title</strong></div>
						<div>$intro</div>
						<a href=\"$link\">Далее...</a>
					</div>";
		}

		wp_reset_postdata(); 
		
		return $str;
		
	}
	
	function test_post_types(){
		register_post_type('reviews', [
			'labels' => [
				'name'               => 'Отзывы', // основное название для типа записи
				'singular_name'      => 'Отзыв', // название для одной записи этого типа
				'add_new'            => 'Добавить новый', // для добавления новой записи
				'add_new_item'       => 'Добавление отзыва', // заголовка у вновь создаваемой записи в админ-панели.
				'edit_item'          => 'Редактирование отзыва', // для редактирования типа записи
				'new_item'           => 'Новый отзыв', // текст новой записи
				'view_item'          => 'Смотреть отзыв', // для просмотра записи этого типа.
				'search_items'       => 'Искать отзывы', // для поиска по этим типам записи
				'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
				'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
				'parent_item_colon'  => '', // для родителей (у древовидных типов)
				'menu_name'          => 'Отзывы', // название меню
			],
			'public'              => true,
			'menu_position'       => 25,
			'menu_icon'           => 'dashicons-format-quote', 
			'hierarchical'        => false,
			'supports'            => array('title', 'editor', 'thumbnail'), // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
		]);
	}
	
	function test_show_reviews(){
		$args = array(
			'orderby'     => 'date',
			'order'       => 'DESC',
			'post_type'   => 'reviews'
		);

		return get_posts($args);
	}
	