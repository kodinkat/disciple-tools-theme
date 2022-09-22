<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly.

class Disciple_Tools_People_Groups_Base {
    public $post_type = 'peoplegroups';
    public $single_name = 'People Group';
    public $plural_name = 'People Groups';

    public function __construct() {

        //setup post type
        add_action( 'after_setup_theme', [ $this, 'after_setup_theme' ], 100 );
        add_filter( 'dt_set_roles_and_permissions', [ $this, 'dt_set_roles_and_permissions' ], 20, 1 ); //after contacts
        add_filter( 'dt_get_post_type_settings', [ $this, 'dt_get_post_type_settings' ], 20, 2 );

        //setup tiles and fields
        add_filter( 'dt_custom_fields_settings', [ $this, 'dt_custom_fields_settings' ], 10, 2 );
        add_filter( 'dt_details_additional_tiles', [ $this, 'dt_details_additional_tiles' ], 10, 2 );

        //list
        add_filter( 'dt_user_list_filters', [ $this, 'dt_user_list_filters' ], 10, 2 );
        add_filter( 'dt_filter_access_permissions', [ $this, 'dt_filter_access_permissions' ], 20, 2 );

        //Hooks
        add_filter( 'dt_nav', [ $this, 'dt_nav_filter' ], 10, 1 );
    }

    public function dt_nav_filter( $navigation_array ) {
        if ( isset( $navigation_array['main'], $navigation_array['main'][ $this->post_type ] ) ) {
            $navigation_array['main'][ $this->post_type ]['hidden'] = ! get_option( Disciple_Tools_People_Groups::$option_key_settings_display_tab );
        }

        return $navigation_array;
    }

    public function after_setup_theme() {
        $this->single_name = __( 'People Group', 'disciple_tools' );
        $this->plural_name = __( 'People Groups', 'disciple_tools' );

        if ( class_exists( 'Disciple_Tools_Post_Type_Template' ) ) {
            new Disciple_Tools_Post_Type_Template( $this->post_type, $this->single_name, $this->plural_name );
        }
    }

    public function dt_get_post_type_settings( $settings, $post_type ) {
        if ( $post_type === $this->post_type ) {
            $settings['label_singular'] = __( 'People Group', 'disciple_tools' );
            $settings['label_plural']   = __( 'People Groups', 'disciple_tools' );
        }

        return $settings;
    }

    public function dt_set_roles_and_permissions( $expected_roles ) {

        if ( ! isset( $expected_roles['multiplier'] ) ) {
            $expected_roles['multiplier'] = [
                'label'       => __( 'Multiplier', 'disciple-tools-plugin-starter-template' ),
                'description' => 'Interacts with Contacts and Groups',
                'permissions' => [
                    'list_all_' . $this->post_type => true,
                    'view_any_' . $this->post_type => true
                ]
            ];
        }

        // if the user can access contact they also can access this post type
        foreach ( $expected_roles as $role => $role_value ) {
            if ( isset( $role_value['permissions']['access_contacts'] ) && $role_value['permissions']['access_contacts'] ) {
                $expected_roles[ $role ]['permissions'][ 'access_' . $this->post_type ]   = true;
                $expected_roles[ $role ]['permissions'][ 'list_all_' . $this->post_type ] = true;
                $expected_roles[ $role ]['permissions'][ 'view_any_' . $this->post_type ] = true;
            }
        }

        if ( isset( $expected_roles['administrator'] ) ) {
            $expected_roles['administrator']['permissions'][ 'list_all_' . $this->post_type ]   = true;
            $expected_roles['administrator']['permissions'][ 'create_' . $this->post_type ]     = true;
            $expected_roles['administrator']['permissions'][ 'view_any_' . $this->post_type ]   = true;
            $expected_roles['administrator']['permissions'][ 'update_any_' . $this->post_type ] = true;
            $expected_roles['administrator']['permissions']['edit_peoplegroups']                = true;
        }
        if ( isset( $expected_roles['dt_admin'] ) ) {
            $expected_roles['dt_admin']['permissions'][ 'list_all_' . $this->post_type ]   = true;
            $expected_roles['dt_admin']['permissions'][ 'create_' . $this->post_type ]     = true;
            $expected_roles['dt_admin']['permissions'][ 'view_any_' . $this->post_type ]   = true;
            $expected_roles['dt_admin']['permissions'][ 'update_any_' . $this->post_type ] = true;
            $expected_roles['dt_admin']['permissions']['edit_peoplegroups']                = true;
        }

        return $expected_roles;
    }

    public function dt_custom_fields_settings( $fields, $post_type ) {
        if ( $post_type === $this->post_type ) {
            /**
             * Basic Framework Fields
             *
             */
            $fields["duplicate_data"]     = [
                "name"    => 'Duplicates', //system string does not need translation
                'type'    => 'array',
                'default' => [],
            ];
            $fields["requires_update"]    = [
                'name'        => __( 'Requires Update', 'disciple_tools' ),
                'description' => '',
                'type'        => 'boolean',
                'default'     => false,
            ];
            $fields['contact_count']      = [
                'name'          => __( "Contacts Total", 'disciple_tools' ),
                'type'          => 'number',
                'default'       => '0',
                'show_in_table' => true
            ];
            $fields['contacts']           = [
                'name'           => __( "Contacts", 'disciple_tools' ),
                'type'           => 'connection',
                "post_type"      => 'contacts',
                'tile'           => 'connections',
                "p2p_direction"  => "from",
                "p2p_key"        => $this->post_type . "_to_contacts",
                'icon'           => get_template_directory_uri() . "/dt-assets/images/contact-generation.svg",
                'create-icon'    => get_template_directory_uri() . '/dt-assets/images/add-contact.svg',
                "in_create_form" => true,
            ];
            $fields['group_total']        = [
                'name'          => __( "Groups Total", 'disciple_tools' ),
                'type'          => 'number',
                'default'       => '0',
                'show_in_table' => true
            ];
            $fields['groups']             = [
                'name'           => __( "Groups", 'disciple_tools' ),
                'type'           => 'connection',
                "post_type"      => 'groups',
                "p2p_direction"  => "from",
                "p2p_key"        => $this->post_type . "_to_groups",
                "tile"           => "connections",
                'icon'           => get_template_directory_uri() . "/dt-assets/images/groups.svg",
                'create-icon'    => get_template_directory_uri() . '/dt-assets/images/add-group.svg',
                "in_create_form" => true,
            ];
            $fields['location_grid']      = [
                'name'           => __( 'Locations', 'disciple_tools' ),
                'description'    => _x( 'The general location where this contact is located.', 'Optional Documentation', 'disciple_tools' ),
                'type'           => 'location',
                'mapbox'         => false,
                "in_create_form" => true,
                "tile"           => "details",
                "icon"           => get_template_directory_uri() . "/dt-assets/images/location.svg",
            ];
            $fields['location_grid_meta'] = [
                'name'        => __( 'Locations', 'disciple_tools' ),
                //system string does not need translation
                'description' => _x( 'The general location where this contact is located.', 'Optional Documentation', 'disciple_tools' ),
                'type'        => 'location_meta',
                "tile"        => "details",
                'mapbox'      => false,
                'hidden'      => true,
                "icon"        => get_template_directory_uri() . "/dt-assets/images/location.svg?v=2",
            ];
            $fields["contact_address"]    = [
                "name"         => __( 'Address', 'disciple_tools' ),
                "icon"         => get_template_directory_uri() . "/dt-assets/images/house.svg",
                "type"         => "communication_channel",
                "tile"         => "details",
                'mapbox'       => false,
                "customizable" => false
            ];

            if ( DT_Mapbox_API::get_key() ) {
                $fields["contact_address"]["custom_display"] = true;
                $fields["contact_address"]["mapbox"]         = true;
                unset( $fields["contact_address"]["tile"] );
                $fields["location_grid"]["mapbox"]      = true;
                $fields["location_grid_meta"]["mapbox"] = true;
                $fields["location_grid"]["hidden"]      = true;
                $fields["location_grid_meta"]["hidden"] = false;
            }

            /**
             * Generation and peer connection fields
             */
            $fields["parents"]  = [
                "name"          => __( 'Parents', 'disciple_tools' ),
                'description'   => '',
                "type"          => "connection",
                "post_type"     => $this->post_type,
                "p2p_direction" => "from",
                "p2p_key"       => $this->post_type . "_to_" . $this->post_type,
                'tile'          => 'connections',
                'icon'          => get_template_directory_uri() . '/dt-assets/images/group-parent.svg',
                'create-icon'   => get_template_directory_uri() . '/dt-assets/images/add-group.svg',
            ];
            $fields["peers"]    = [
                "name"          => __( 'Peers', 'disciple_tools' ),
                'description'   => '',
                "type"          => "connection",
                "post_type"     => $this->post_type,
                "p2p_direction" => "any",
                "p2p_key"       => $this->post_type . "_to_peers",
                'tile'          => 'connections',
                'icon'          => get_template_directory_uri() . '/dt-assets/images/group-peer.svg',
                'create-icon'   => get_template_directory_uri() . '/dt-assets/images/add-group.svg',
            ];
            $fields["children"] = [
                "name"          => __( 'Children', 'disciple_tools' ),
                'description'   => '',
                "type"          => "connection",
                "post_type"     => $this->post_type,
                "p2p_direction" => "to",
                "p2p_key"       => $this->post_type . "_to_" . $this->post_type,
                'tile'          => 'connections',
                'icon'          => get_template_directory_uri() . '/dt-assets/images/group-child.svg',
                'create-icon'   => get_template_directory_uri() . '/dt-assets/images/add-group.svg',
            ];
        }

        return $fields;
    }

    public function dt_details_additional_tiles( $tiles, $post_type = "" ) {
        if ( $post_type === $this->post_type ) {
            $tiles["connections"] = [ "label" => __( "Connections", 'disciple_tools' ) ];
            $tiles["other"]       = [ "label" => __( "Other", 'disciple_tools' ) ];
        }

        return $tiles;
    }

    //build list page filters
    public function dt_user_list_filters( $filters, $post_type ) {
        if ( $post_type === $this->post_type ) {
            $filters["tabs"][] = [
                "key"   => "all",
                "label" => _x( "All", 'List Filters', 'disciple_tools' ),
                "count" => 0,
                "order" => 10
            ];

            // add assigned to me filters
            $filters["filters"][] = [
                'ID'    => 'all',
                'tab'   => 'all',
                'name'  => _x( "All", 'List Filters', 'disciple_tools' ),
                'query' => [
                    'sort' => '-post_date'
                ],
                "count" => 0
            ];
        }

        return $filters;
    }

    public function dt_filter_access_permissions( $permissions, $post_type ) {
        if ( $post_type === $this->post_type ) {
            if ( DT_Posts::can_view_all( $post_type ) ) {
                $permissions = [];
            }
        }

        return $permissions;
    }

}

