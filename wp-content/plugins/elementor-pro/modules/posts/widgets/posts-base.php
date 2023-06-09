<?php
namespace ElementorPro\Modules\Posts\Widgets;

use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
use ElementorPro\Base\Base_Widget;
use Elementor\Controls_Manager;
use ElementorPro\Modules\Posts\Traits\Button_Widget_Trait;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Class Posts
 */
abstract class Posts_Base extends Base_Widget {
	use Button_Widget_Trait;

	const LOAD_MORE_ON_CLICK = 'load_more_on_click';
	const LOAD_MORE_INFINITE_SCROLL = 'load_more_infinite_scroll';

	/**
	 * @var \WP_Query
	 */
	protected $query = null;

	protected $_has_template_content = false;

	public function get_icon() {
		return 'eicon-post-list';
	}

	public function get_script_depends() {
		return [ 'imagesloaded' ];
	}

	public function get_query() {
		return $this->query;
	}

	public function render() {}

	public function  register_load_more_button_style_controls() {
		$this->add_control(
			'heading_load_more_style_button',
			[
				'label' => __( 'Button', 'elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'pagination_type' => 'load_more_on_click',
				],
			]
		);

		$this->register_button_style_controls( [
			'section_condition' => [
				'pagination_type' => 'load_more_on_click',
			],
		] );
	}

	public function register_load_more_message_style_controls() {
		$this->add_control(
			'heading_load_more_on_click_no_posts_message',
			[
				'label' => __( 'No More Posts Message', 'elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'pagination_type' => 'load_more_on_click',
				],
			]
		);

		$this->add_control(
			'heading_load_more_on_click_infinity_scroll_no_posts_message',
			[
				'label' => __( 'No More Posts Message', 'elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'pagination_type' => 'load_more_infinite_scroll',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'load_more_no_posts_message',
				'selector' => '{{WRAPPER}} .e-load-more-message',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->add_control(
			'load_more_no_posts_message_color',
			[
				'label' => __( 'Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}' => '--load-more-message-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'load_more_spinner_color',
			[
				'label' => __( 'Spinner Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}' => '--load-more-spinner-color: {{VALUE}};',
				],
				'separator' => 'before',
				'condition' => [
					'load_more_spinner[value]!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'load_more_spacing',
			[
				'label' => __( 'Spacing', 'elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => '--load-more—spacing: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
	}

	public function register_pagination_section_controls() {
		$this->start_controls_section(
			'section_pagination',
			[
				'label' => __( 'Pagination', 'elementor-pro' ),
			]
		);

		$this->add_control(
			'pagination_type',
			[
				'label' => __( 'Pagination', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => $this->get_pagination_type_options(),
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'pagination_page_limit',
			[
				'label' => __( 'Page Limit', 'elementor-pro' ),
				'default' => '5',
				'condition' => [
					'pagination_type!' => [
						'load_more_on_click',
						'load_more_infinite_scroll',
						'',
					],
				],
			]
		);

		$this->add_control(
			'pagination_numbers_shorten',
			[
				'label' => __( 'Shorten', 'elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'condition' => [
					'pagination_type' => [
						'numbers',
						'numbers_and_prev_next',
					],
				],
			]
		);

		$this->add_control(
			'pagination_prev_label',
			[
				'label' => __( 'Previous Label', 'elementor-pro' ),
				'default' => __( '&laquo; Previous', 'elementor-pro' ),
				'condition' => [
					'pagination_type' => [
						'prev_next',
						'numbers_and_prev_next',
					],
				],
			]
		);

		$this->add_control(
			'pagination_next_label',
			[
				'label' => __( 'Next Label', 'elementor-pro' ),
				'default' => __( 'Next &raquo;', 'elementor-pro' ),
				'condition' => [
					'pagination_type' => [
						'prev_next',
						'numbers_and_prev_next',
					],
				],
			]
		);

		$this->add_control(
			'pagination_align',
			[
				'label' => __( 'Alignment', 'elementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'elementor-pro' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'elementor-pro' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'elementor-pro' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .elementor-pagination' => 'text-align: {{VALUE}};',
				],
				'condition' => [
					'pagination_type!' => [
						'load_more_on_click',
						'load_more_infinite_scroll',
						'',
					],
				],
			]
		);

		$this->add_control(
			'load_more_spinner',
			[
				'label' => __( 'Spinner', 'elementor-pro' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-spinner',
					'library' => 'fa-solid',
				],
				'exclude_inline_options' => [ 'svg' ],
				'recommended' => [
					'fa-solid' => [
						'spinner',
						'cog',
						'sync',
						'sync-alt',
						'asterisk',
						'circle-notch',
					],
				],
				'skin' => 'inline',
				'label_block' => false,
				'condition' => [
					'pagination_type' => [
						'load_more_on_click',
						'load_more_infinite_scroll',
					],
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'heading_load_more_button',
			[
				'label' => __( 'Button', 'elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'pagination_type' => 'load_more_on_click',
				],
			]
		);

		$this->register_button_content_controls( [
			'button_text' => __( 'Load More', 'elementor-pro' ),
			'control_label_name' => __( 'Button Text', 'elementor-pro' ),
			'prefix_class' => 'load-more-align-',
			'alignment_default' => 'center',
			'section_condition' => [
				'pagination_type' => 'load_more_on_click',
			],
			'exclude_inline_options' => [ 'svg' ],
		] );

		$this->remove_control( 'button_type' );
		$this->remove_control( 'link' );
		$this->remove_control( 'size' );

		$this->add_control(
			'heading_load_more_no_posts_message',
			[
				'label' => __( 'No More Posts Message', 'elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'pagination_type' => [
						'load_more_on_click',
						'load_more_infinite_scroll',
					],
				],
			]
		);

		$this->add_responsive_control(
			'load_more_no_posts_message_align',
			[
				'label' => __( 'Alignment', 'elementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => __( 'Left', 'elementor-pro' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'elementor-pro' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'elementor-pro' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'elementor-pro' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => '--load-more-message-alignment: {{VALUE}};',
				],
				'condition' => [
					'pagination_type' => [
						'load_more_on_click',
						'load_more_infinite_scroll',
					],
				],
			]
		);

		$this->add_control(
			'load_more_no_posts_message_switcher',
			[
				'label' => __( 'Custom Messages', 'elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'condition' => [
					'pagination_type' => [
						'load_more_on_click',
						'load_more_infinite_scroll',
					],
				],
			]
		);

		$this->add_control(
			'load_more_no_posts_custom_message',
			[
				'label' => __( 'No more posts message', 'elementor-pro' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'No more posts to show', 'elementor-pro' ),
				'condition' => [
					'pagination_type' => [
						'load_more_on_click',
						'load_more_infinite_scroll',
					],
					'load_more_no_posts_message_switcher' => 'yes',
				],
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		// Pagination style controls for prev/next and numbers pagination.
		$this->start_controls_section(
			'section_pagination_style',
			[
				'label' => __( 'Pagination', 'elementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'pagination_type!' => [
						'load_more_on_click',
						'load_more_infinite_scroll',
						'',
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pagination_typography',
				'selector' => '{{WRAPPER}} .elementor-pagination',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->add_control(
			'pagination_color_heading',
			[
				'label' => __( 'Colors', 'elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'pagination_colors' );

		$this->start_controls_tab(
			'pagination_color_normal',
			[
				'label' => __( 'Normal', 'elementor-pro' ),
			]
		);

		$this->add_control(
			'pagination_color',
			[
				'label' => __( 'Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-pagination .page-numbers:not(.dots)' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pagination_color_hover',
			[
				'label' => __( 'Hover', 'elementor-pro' ),
			]
		);

		$this->add_control(
			'pagination_hover_color',
			[
				'label' => __( 'Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-pagination a.page-numbers:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pagination_color_active',
			[
				'label' => __( 'Active', 'elementor-pro' ),
			]
		);

		$this->add_control(
			'pagination_active_color',
			[
				'label' => __( 'Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-pagination .page-numbers.current' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'pagination_spacing',
			[
				'label' => __( 'Space Between', 'elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'separator' => 'before',
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'body:not(.rtl) {{WRAPPER}} .elementor-pagination .page-numbers:not(:first-child)' => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 );',
					'body:not(.rtl) {{WRAPPER}} .elementor-pagination .page-numbers:not(:last-child)' => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 );',
					'body.rtl {{WRAPPER}} .elementor-pagination .page-numbers:not(:first-child)' => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 );',
					'body.rtl {{WRAPPER}} .elementor-pagination .page-numbers:not(:last-child)' => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 );',
				],
			]
		);

		$this->add_responsive_control(
			'pagination_spacing_top',
			[
				'label' => __( 'Spacing', 'elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-pagination' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();

		// Pagination style controls for on-load pagination with type on-click/infinity-scroll.
		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Pagination', 'elementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'pagination_type' => [
						'load_more_on_click',
						'load_more_infinite_scroll',
					],
				],
			]
		);

		$this->register_load_more_button_style_controls();

		$this->register_load_more_message_style_controls();

		$this->end_controls_section();
	}

	abstract public function query_posts();

	public function get_current_page() {
		if ( '' === $this->get_settings( 'pagination_type' ) ) {
			return 1;
		}

		return max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
	}

	private function get_wp_link_page( $i ) {
		if ( ! is_singular() || is_front_page() ) {
			return get_pagenum_link( $i );
		}

		// Based on wp-includes/post-template.php:957 `_wp_link_page`.
		global $wp_rewrite;
		$post = get_post();
		$query_args = [];
		$url = get_permalink();

		if ( $i > 1 ) {
			if ( '' === get_option( 'permalink_structure' ) || in_array( $post->post_status, [ 'draft', 'pending' ] ) ) {
				$url = add_query_arg( 'page', $i, $url );
			} elseif ( get_option( 'show_on_front' ) === 'page' && (int) get_option( 'page_on_front' ) === $post->ID ) {
				$url = trailingslashit( $url ) . user_trailingslashit( "$wp_rewrite->pagination_base/" . $i, 'single_paged' );
			} else {
				$url = trailingslashit( $url ) . user_trailingslashit( $i, 'single_paged' );
			}
		}

		if ( is_preview() ) {
			if ( ( 'draft' !== $post->post_status ) && isset( $_GET['preview_id'], $_GET['preview_nonce'] ) ) {
				$query_args['preview_id'] = wp_unslash( $_GET['preview_id'] );
				$query_args['preview_nonce'] = wp_unslash( $_GET['preview_nonce'] );
			}

			$url = get_preview_post_link( $post, $query_args, $url );
		}

		return $url;
	}

	public function get_posts_nav_link( $page_limit = null ) {
		if ( ! $page_limit ) {
			$page_limit = $this->query->max_num_pages;
		}

		$return = [];

		$paged = $this->get_current_page();

		$link_template = '<a class="page-numbers %s" href="%s">%s</a>';
		$disabled_template = '<span class="page-numbers %s">%s</span>';

		if ( $paged > 1 ) {
			$next_page = intval( $paged ) - 1;
			if ( $next_page < 1 ) {
				$next_page = 1;
			}

			$return['prev'] = sprintf( $link_template, 'prev', $this->get_wp_link_page( $next_page ), $this->get_settings( 'pagination_prev_label' ) );
		} else {
			$return['prev'] = sprintf( $disabled_template, 'prev', $this->get_settings( 'pagination_prev_label' ) );
		}

		$next_page = intval( $paged ) + 1;

		if ( $next_page <= $page_limit ) {
			$return['next'] = sprintf( $link_template, 'next', $this->get_wp_link_page( $next_page ), $this->get_settings( 'pagination_next_label' ) );
		} else {
			$return['next'] = sprintf( $disabled_template, 'next', $this->get_settings( 'pagination_next_label' ) );
		}

		return $return;
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_layout',
			[
				'label' => __( 'Layout', 'elementor-pro' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->end_controls_section();
	}

	protected function get_pagination_type_options() {
		return [
			'' => __( 'None', 'elementor-pro' ),
			'numbers' => __( 'Numbers', 'elementor-pro' ),
			'prev_next' => __( 'Previous/Next', 'elementor-pro' ),
			'numbers_and_prev_next' => __( 'Numbers', 'elementor-pro' ) . ' + ' . __( 'Previous/Next', 'elementor-pro' ),
			self::LOAD_MORE_ON_CLICK => __( 'Load on Click', 'elementor-pro' ),
			self::LOAD_MORE_INFINITE_SCROLL => __( 'Infinite Scroll', 'elementor-pro' ),
		];
	}

	public function render_plain_content() {}
}
