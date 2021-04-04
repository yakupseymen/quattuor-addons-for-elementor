<?php

// Quattuor_Header_Search

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Quattuor_Header_Search extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @since 0.1.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'quattuor-header-search';
	}

	/**
	 * Get widget title.
	 *
	 * @since 0.1.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Search', 'quattuor-addons ' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since 0.1.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'fa fa-search';
	}

	/**
	 * Get widget categories.
	 *
	 * @since 0.1.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'quattuor-header' ];
	}

	/**
	 * Register widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 0.1.0
	 * @access protected
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Title', 'quattuor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'search_title',
			[
				'label' => __( 'Search Title', 'quattuor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Search', 'quattuor-addons' ),
				'placeholder' => __( 'Type your title here', 'quattuor-addons' ),
			]
		);

		$this->add_control(
			'search_placeholder',
			[
				'label' => __( 'Form Placeholder', 'quattuor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Search anythig...', 'quattuor-addons' ),
				'placeholder' => __( 'Type your title here', 'quattuor-addons' ),
			]
		);

		$this->add_control(
			'search_type',
			[
				'label' => __( 'Search Type', 'quattuor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'product',
				'options' => [
					'product'  => __( 'Product', 'quattuor-addons' ),
					'post' => __( 'Post', 'quattuor-addons' ),
				],
			]
		);

        $this->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'quattuor-addons' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-search',
					'library' => 'solid',
				],
			]
		);

		$this->add_control(
			'icon_close',
			[
				'label' => __( 'Close Icon', 'quattuor-addons' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'far fa-times-circle',
					'library' => 'regular',
				],
			]
		);

		$this->end_controls_section();

		/* Style Tab */

		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Style', 'quattuor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label' => __( 'Icon Size', 'quattuor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 24,
				],
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .quattuor-action-button-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => __( 'Icon Color', 'quattuor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_2,
				],
				'default' => '#000000',
				'selectors' => [
					'{{WRAPPER}} .quattuor-action-button-icon' => 'color: {{VALUE}}',
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'content_color',
			[
				'label' => __( 'Content Color', 'quattuor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_2,
				],
				'default' => '#000000',
				'selectors' => [
					'{{WRAPPER}} .quattuor-search-screen' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'menu_bg',
			[
				'label' => __( 'Background Color', 'quattuor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_2,
				],
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .quattuor-search-screen' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Typography', 'quattuor-addons' ),
				'scheme' =>\Elementor\Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .quattuor-search-screen',
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 0.1.0
	 * @access protected
	 */
	protected function render() {

        $settings = $this->get_settings_for_display();

        ?>
		<a href="#" onclick="toggleSearchScreen2()" class="quattuor-action-button">
			<div class="quattuor-action-button-icon">
			<span>
			<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
			</span>
			</div>
		</a>

		<div class="quattuor-search-screen">
			
			<div class="quattuor-search-screen-container">
				<div class="quattuor-search-screen-header">
					<h3 class="quattuor-search-screen-title"><?php echo $settings['search_title']; ?></h3>
					<a class="quattuor-action-button" onclick="toggleSearchScreen2()">
						<div class="quattuor-action-button-icon">
							<?php \Elementor\Icons_Manager::render_icon( $settings['icon_close'], [ 'aria-hidden' => 'true' ] ); ?>
						</div>
					</a>
				</div>
				
				<div class="quattuor-search-screen-form">
					<form role="search" method="get" class="woocommerce-product-search" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
						<label class="screen-reader-text" for="s"><?php _e( 'Search for:', 'woocommerce' ); ?></label>
						<input type="search" class="search-field" placeholder="<?php echo $settings['search_placeholder']; ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo $settings['search_placeholder']; ?>" />
						<input type="hidden" name="post_type" value="<?php echo $settings['search_type']; ?>" />
					</form>
				</div>

			</div>
		</div>
			
        <?php




	}

}