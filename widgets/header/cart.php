<?php

// Quattuor_Header_Cart

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Quattuor_Header_Cart extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @since 0.1.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'quattuor-header-cart';
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
		return __( 'Cart', 'quattuor-addons ' );
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
		return 'fa fa-shopping-cart';
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
				'label' => __( 'My Cart', 'quattuor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'my_cart',
			[
				'label' => __( 'My Cart Title', 'quattuor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'My Cart', 'quattuor-addons' ),
				'placeholder' => __( 'Type your title here', 'quattuor-addons' ),
			]
		);

        $this->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'quattuor-addons' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-shopping-cart',
					'library' => 'solid',
				],
			]
		);

		$this->add_control(
			'show_title',
			[
				'label' => __( 'Show Title', 'quattuor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'quattuor-addons' ),
				'label_off' => __( 'Hide', 'quattuor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_counter',
			[
				'label' => __( 'Show Counter', 'quattuor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'quattuor-addons' ),
				'label_off' => __( 'Hide', 'quattuor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
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
			'icon_space',
			[
				'label' => __( 'Icon Spacing', 'quattuor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 5,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .quattuor-action-button-content' => 'margin-left: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .quattuor-action-button-content' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Typography', 'quattuor-addons' ),
				'scheme' =>\Elementor\Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .quattuor-action-button-content, {{WRAPPER}} .quattuor-cart-badge',
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
        
		/*

			<a class="quattuor-action-btn quattuor-action-btn-my-cart flex-center" href="<?php echo esc_url( wc_get_page_permalink( 'cart' ) ); ?>" title="<?php echo $settings['my_cart']; ?>">
			<div class="quattuor-action-btn-icon flex-center">
				<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
				<span class="cart-badge flex-center"><?php //echo WC()->cart->get_cart_contents_count() ?></span>
			</div>
			<div class="quattuor-action-btn-content">
				<small><?php echo $settings['my_cart']; ?></small>
				<div class="cart-total"><?php //echo WC()->cart->get_cart_total(); ?></div>
			</div>
		</a>

		*/
		

        ?>
	
		<a class="quattuor-action-button w-content" href="<?php echo esc_url( wc_get_page_permalink( 'cart' ) ); ?>" title="<?php echo $settings['my_cart']; ?>">
			<div class="quattuor-action-button-icon">
				<span>
					<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
				</span>
				<?php if ( 'yes' === $settings['show_counter'] ) : ?>
					<span class="quattuor-cart-badge"><?php //echo WC()->cart->get_cart_contents_count() ?></span>
				<?php endif; ?>
			</div>
			<?php if ( 'yes' === $settings['show_title'] ) : ?>
			<div class="quattuor-action-button-content">
				<small><?php echo $settings['my_cart']; ?></small>
				<div class="quattuor-cart-total"><?php //echo WC()->cart->get_cart_total(); ?></div>
			</div>
			<?php endif; ?>
		</a>
        <?php




	}

}