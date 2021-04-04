<?php

// Quattuor_Vertical_Menu

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Quattuor_Vertical_Menu extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @since 0.1.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'quattuor-header-vertical-menu';
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
		return __( 'Vertical Menu', 'quattuor-addons ' );
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
		return 'fa fa-bars';
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
	 * Retrieve the list of available menus.
	 *
	 * Used to get the list of available menus.
	 *
	 * @since 0.1.1
	 * @access private
	 *
	 * @return array get WordPress menus list.
	 */
	private function get_available_menus() {

		$menus = wp_get_nav_menus();
		$options = [];
		foreach ( $menus as $menu ) {
			$options[ $menu->slug ] = $menu->name;
		}
		return $options;
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
				'label' => __( 'Vertical Menu', 'quattuor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$menus = $this->get_available_menus();

		if ( ! empty( $menus ) ) {
			$this->add_control(
				'menu',
				[
					'label'        => __( 'Menu', 'header-footer-elementor' ),
					'type'         => \Elementor\Controls_Manager::SELECT,
					'options'      => $menus,
					'default'      => array_keys( $menus )[0],
					'save_default' => true,
					'separator'    => 'after',
					/* translators: %s Nav menu URL */
					'description'  => sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'quattuor-addons' ), admin_url( 'nav-menus.php' ) ),
				]
			);
		} else {
			$this->add_control(
				'menu',
				[
					'type'            => \Elementor\Controls_Manager::RAW_HTML,
					/* translators: %s Nav menu URL */
					'raw'             => sprintf( __( '<strong>There are no menus in your site.</strong><br>Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'quattuor-addons' ), admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
					'separator'       => 'after',
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
		}

		$this->add_control(
			'logo_image',
			[
				'label' => __( 'Choose Logo Image', 'elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name' => 'logo_image_dimension', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'include' => [],
				'default' => 'full',
			]
		);

        $this->add_control(
			'icon',
			[
				'label' => __( 'Menu Icon', 'quattuor-addons' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-bars',
					'library' => 'solid',
				],
				'separator' => 'before',
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
					'{{WRAPPER}} .quattuor-vertical-menu nav a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'menu_bg',
			[
				'label' => __( 'Menu Background', 'quattuor-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_2,
				],
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .quattuor-vertical-menu' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Typography', 'quattuor-addons' ),
				'scheme' =>\Elementor\Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .quattuor-vertical-menu',
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


		$menus = $this->get_available_menus();

		if ( empty( $menus ) ) {
			return false;
		}


        $settings = $this->get_settings_for_display();
		

        ?>

	<a href="#" onclick="toggleSideMenu2()" class="quattuor-action-button">
		<div class="quattuor-action-button-icon">
		<span>
		<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
		</span>
		</div>
	</a>


    <div class="quattuor-vertical-menu">
        <div class="site-title">
			<?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'logo_image_dimension', 'logo_image' ); ?>
        </div>

        <nav class="nav" id="nav">
			<?php $args = ['menu' => $settings['menu'], 'container' => 'false'];
            wp_nav_menu( $args ); ?>
        </nav> 

        <div class="quattuor-vertical-menu-close-button">
            <a class="quattuor-action-button" onclick="toggleSideMenu2()">
                <div class="quattuor-action-button-icon">
                <?php \Elementor\Icons_Manager::render_icon( $settings['icon_close'], [ 'aria-hidden' => 'true' ] ); ?>
                </div>
            </a>
        </div>
    </div> <!-- side menu -->
			
        <?php




	}

}