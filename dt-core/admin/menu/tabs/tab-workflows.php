<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Class Disciple_Tools_Tab_Workflows
 */
class Disciple_Tools_Tab_Workflows extends Disciple_Tools_Abstract_Menu_Base {
    private static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    } // End instance()

    /**
     * Constructor function.
     *
     * @access  public
     * @since   0.1.0
     */
    public function __construct() {
        add_action( 'admin_menu', [ $this, 'add_submenu' ], 125 );
        add_action( 'dt_utilities_tab_menu', [ $this, 'add_tab' ], 125, 1 );
        add_action( 'dt_utilities_tab_content', [ $this, 'content' ], 125, 1 );

        parent::__construct();
    } // End __construct()

    public function add_submenu() {
        add_submenu_page( 'dt_utilities', __( 'Workflows', 'disciple_tools' ), __( 'Workflows', 'disciple_tools' ), 'manage_dt', 'dt_utilities&tab=workflows', [
            'Disciple_Tools_Settings_Menu',
            'content'
        ] );
    }

    public function add_tab( $tab ) {
        echo '<a href="' . esc_url( admin_url() ) . 'admin.php?page=dt_utilities&tab=workflows" class="nav-tab ';
        if ( $tab == 'workflows' ) {
            echo 'nav-tab-active';
        }
        echo '">' . esc_attr__( 'Workflows' ) . '</a>';
    }

    public function content( $tab ) {
        if ( 'workflows' == $tab ) {

            $this->template( 'begin' );

            $this->workflows_management_section();
            $this->workflows_design_section();

            $this->template( 'right_column' );

            $this->workflows_properties_section();

            $this->template( 'end' );

        }
    }

    private function workflows_management_section() {
        $this->box( 'top', 'Workflows Management', [ "col_span" => 4 ] );
        ?>

        <select style="min-width: 100%;" id="workflows_management_section_select">
            <option disabled selected value="">--- available workflows ---</option>
            <option value="wkf1">Workflow One</option>
        </select>

        <br><br>
        <span style="float:right;">
            <a id="workflows_management_section_new_but"
               class="button float-right"><?php esc_html_e( "New Workflow", 'disciple_tools' ) ?></a>
        </span>

        <?php
        $this->box( 'bottom' );
    }

    private function workflows_design_section() {
        echo '<div id="workflows_design_section_div" style="display: none;">';
        $this->box( 'top', 'Workflow Design', [ "col_span" => 4 ] );
        ?>

        <input type="text" style="min-width: 100%;" id="workflows_design_section_title"
               placeholder="Workflow Graph Title">
        <br><br>
        <div style="min-width: 100%; min-height: 500px;" id="workflows_design_section_canvas"></div>

        <br><br>
        <span style="float:right;">
            <a id="workflows_design_section_save_but"
               class="button float-right"><?php esc_html_e( "Save", 'disciple_tools' ) ?></a>
        </span>

        <?php
        $this->box( 'bottom' );
        echo '</div>';
    }

    private function workflows_properties_section() {
        echo '<div id="workflows_properties_section_div" style="display: none;">';
        $this->box( 'top', 'Workflow Properties', [ "col_span" => 3 ] );
        ?>

        <div id="workflows_properties_section_display_area"></div>

        <?php
        $this->box( 'bottom' );
        echo '</div>';

        // Include additional helper divs
        include( 'tab-workflows-props-node-start.php' );
        include( 'tab-workflows-props-node-condition.php' );
        include( 'tab-workflows-props-node-action.php' );
    }
}

Disciple_Tools_Tab_Workflows::instance();
