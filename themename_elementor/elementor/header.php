<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
* Text Widget_Header
*/
class Widget_Header extends Widget_Base {

	/**
	* Retrieve text editor widget name.
	*
	* @access public
	*
	* @return string Widget name.
	*/
	public function get_name() {
		return 'widget-header';
	}

	/**
	* Retrieve text editor widget title.
	*
	* @access public
	*
	* @return string Widget title.
	*/
	public function get_title() {
		return __( 'Header', 'elementor' );
	}

	/**
	* Retrieve text editor widget icon.
	*
	* @access public
	*
	* @return string Widget icon.
	*/
	public function get_icon() {
		return 'icon-name';
	}

	/**
	* Register text editor widget controls.
	*
	* Adds different input fields to allow the user to change and customize the widget settings.
	*
	* @access protected
	*/
	protected function _register_controls() {
		$this->start_controls_section(
			'section_title',
			[
				'label' => __( 'Título', 'elementor' ),
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Título', 'elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => __( '', 'elementor' ),
				'default' => __( 'Bloco de texto. Clique em editar para mudar o conteúdo.', 'elementor' ),
			]
		);

		$this->add_control(
			'color',
			[
				'label' => __( 'Cor', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .main-inner-header-tt' => 'color: {{VALUE}};',
					'{{WRAPPER}} .main-inner-header-tt i' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'colorletter',
			[
				'label' => __( 'Cor da primeira letra', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
				'selectors' => [
					'{{WRAPPER}} .main-inner-header-tt span' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_image',
			[
				'label' => __( 'Imagem', 'elementor' ),
			]
		);

		$this->add_control(
			'image',
			[
				'label' => __( 'Imagem de fundo', 'elementor' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	* Render text editor widget output on the frontend.
	*
	* Written in PHP and used to generate the final HTML.
	*
	* @access protected
	*/
	protected function render() {
		$settings = $this->get_settings();

		$title = $settings['title'];
		if($title){
			$title_first_letter = $title{0};
			$title = substr($title, 1);
		}

		if($settings['image']['url'] || $title):

		?>

			<div class="main-inner-header" style="background-image: url(<?php echo $settings['image']['url']; ?>);">

				<div class="container">
					<div class="main-inner-header-tt" style="color: <?php echo $settings['color']; ?>;">
						<i style="background-color: <?php echo $settings['color']; ?>;"></i>
						<span style="color: <?php echo $settings['colorletter']; ?>"><?php echo $title_first_letter; ?></span><?php echo nl2br($title); ?>
					</div>

				</div>

			</div>

<?php
		else:
?>

			<div class="modelo-geral-header bg-blue">
			</div>

<?php
		endif;
 ?>

			<div class="container">
				<div class="main-breadcrumbs">
					<?php if(get_the_title()=='Home'): ?>
					<?php
						if(get_current_blog_id() != 1){

							$blog_details = get_blog_details(get_current_blog_id());
							$sitename = $blog_details->blogname;

							if( strpos($blog_details->blogname, 'empresas') || strpos($blog_details->blogname, 'contratar') ):
								$sitename = 'Benefícios para Empresas';
							endif;

							if( strpos($blog_details->blogname, 'estabelecimentos') || strpos($blog_details->blogname, 'aceite') || strpos($blog_details->blogname, 'Aceite') ):
								$sitename = 'Benefícios para Estabelecimentos';
							endif;

							if( strpos($blog_details->blogname, 'usuários') || strpos($blog_details->blogname, 'serviços') ):
								$sitename = 'Benefícios para Usuários';
							endif;
							
							echo '<h1><strong>'.$sitename.'</strong></h1>';
						}
					?>
					<?php else: ?>
						<ul>
							<li><a href="<?php echo network_site_url(); ?>">Página Inicial</a></li>
							<?php
								if(get_current_blog_id() != 1){

									$blog_details = get_blog_details(get_current_blog_id());
									$sitename = $blog_details->blogname;

									if( strpos($blog_details->blogname, 'empresas') || strpos($blog_details->blogname, 'contratar') ):
										$sitename = 'Empresas';
									endif;

									if( strpos($blog_details->blogname, 'estabelecimentos') || strpos($blog_details->blogname, 'aceite') || strpos($blog_details->blogname, 'Aceite') ):
										$sitename = 'Estabelecimentos';
									endif;

									if( strpos($blog_details->blogname, 'usuários') || strpos($blog_details->blogname, 'serviços') ):
										$sitename = 'Usuários';
									endif;
									
									echo '<li><a href="'.get_bloginfo('url').'">'.$sitename.'</a></li>';
								}
								$post_parent_id = wp_get_post_parent_id(get_the_id());
								if($post_parent_id){
								    $post_parent = get_post($post_parent_id);
								    $post_parent_title = $post_parent->post_title;
								    echo '<li><a href="'.get_permalink($post_parent_id).'">'.$post_parent_title.'</a></li>';
								}
							 ?>
						</ul>
						<h1><?php the_title(); ?></h1>
					<?php endif; ?>
				</div>
			</div>


<?php

	}

	/**
	* Render text editor widget as plain content.
	*
	* Override the default behavior by printing the content without rendering it.
	*
	* @access public
	*/
	public function render_plain_content() {
		// In plain mode, render without shortcode
		echo $this->get_settings( 'editor' );
	}

	/**
	* Render text editor widget output in the editor.
	*
	* Written as a Backbone JavaScript template and used to generate the live preview.
	*
	* @access protected
	*/
	protected function _content_template() {
?>

		<#
			var title = settings.title;
			var title_first_letter = title.charAt(0);
			title = title.substring(1);

			function nl2br (str, is_xhtml) {
			    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
			    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
			}

			title = nl2br(title);

			if ( '' !== settings.image.url ) {
				var image = {
					id: settings.image.id,
					url: settings.image.url,
					size: settings.image_size,
					dimension: settings.image_custom_dimension,
					model: editModel
				};

				var image_url = elementor.imagesManager.getImageUrl( image );

				if ( ! image_url ) {
					return;
				}
			}
			if(settings.image.url || title){
		#>

		<div class="main-inner-header" style="background-image: url({{ image_url }});">

			<div class="container">
				<div class="main-inner-header-tt" style="{{{ settings.color }}};">
					<i style="{{{ settings.color }}};"></i>
					<span style="{{{ settings.colorletter }}};">{{{ title_first_letter }}}</span>{{{ title }}}
				</div>

			</div>

		</div>

		<# }else{ #>

			<div class="modelo-geral-header bg-blue">
			</div>

		<# } #>


		<div class="container">
			<div class="main-breadcrumbs">
				<ul>
					<li><a href="<?php echo network_site_url(); ?>">Página Inicial</a></li>
					<li><a href="<?php bloginfo('url'); ?>">Empresas</a></li>
				</ul>
				<h1><?php the_title(); ?></h1>
			</div>
		</div>



		<?php
	}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_Header() );

