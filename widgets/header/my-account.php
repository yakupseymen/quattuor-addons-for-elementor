<?php

// Quattuor_Header_Account

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Quattuor_Header_Account extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @since 0.1.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'quattuor-header-account';
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
		return __( 'My Account', 'quattuor-addons ' );
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
		return 'fa fa-user';
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
				'label' => __( 'My Account', 'quattuor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'my_account_title',
			[
				'label' => __( 'My Account Title', 'quattuor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'My Account', 'quattuor-addons' ),
				'placeholder' => __( 'Type your title here', 'quattuor-addons' ),
			]
		);

        $this->add_control(
			'my_account_title_not_login',
			[
				'label' => __( 'My Account Title (Not Login)', 'quattuor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Hello, sign', 'quattuor-addons' ),
				'placeholder' => __( 'Type your title here', 'quattuor-addons' ),
			]
		);
		

        $this->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'quattuor-addons' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'far fa-user',
					'library' => 'regular',
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
				'selector' => '{{WRAPPER}} .quattuor-action-button-content',
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


	<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="quattuor-action-button w-content">
		<div class="quattuor-action-button-icon">
			<span>
			<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
			</span>
		</div>
		<?php if ( 'yes' === $settings['show_title'] ) : ?>
			<div class="quattuor-action-button-content">
				<?php if (!is_user_logged_in()): ?>
				<small><?php echo $settings['my_account_title_not_login']; ?></small>
				<?php else: ?>
					<small><?php if(wp_get_current_user()->first_name) echo wp_get_current_user()->first_name; else echo wp_get_current_user()->user_login; ?></small>
				<?php endif; ?>
				<div><?php echo $settings['my_account_title']; ?></div>
			</div>
		<?php endif; ?>
	</a>


        <?php

	}

}