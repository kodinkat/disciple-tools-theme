<?php
/**
 * This is where DT functions and classes go to die.
 */

/**
 * Class Disciple_Tools_Contacts
 * @deprecated version 1.0
 */
class Disciple_Tools_Contacts {
    /**
     * @param $query
     * @return array|mixed|WP_Error
     * @deprecated
     */
    public static function search_viewable_contacts( $query ) {
        _deprecated_function( __CLASS__ . '::' . __FUNCTION__, '1.0', 'Disciple_Tools_Post::search_viewable_post()' );

        $result = Disciple_Tools_Posts::search_viewable_post( 'contacts', $query, $check_permissions = false );
        $result['contacts'] = $result['posts'];

        return $result;
    }

    /**
     * @param $contact_id
     * @param bool $use_cache
     * @param bool $check_permissions
     * @return array|WP_Error
     * @deprecated version 1.0
     */
    public static function get_contact( $contact_id, $use_cache = true, $check_permissions = true ) {
        _deprecated_function( __CLASS__ . '::' . __FUNCTION__, '1.0', 'DT_Posts::get_post()' );
        return DT_Posts::get_post( 'contacts', (int) $contact_id, (bool) $use_cache, (bool) $check_permissions, $silent = false );
    }
}

/**
 * Class Disciple_Tools_Contact_Post_Type
 * @deprecated version 1.0
 */
class Disciple_Tools_Contact_Post_Type {
    private static $_instance = null;

    /**
     * @return Disciple_Tools_Contact_Post_Type|null
     * @deprecated version 1.0
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct() {}

    /**
     * @return mixed|void
     * @deprecated version 1.0
     */
    public function get_custom_fields_settings() {
        _deprecated_function( __CLASS__ . '::' . __FUNCTION__, '1.0', 'Disciple_Tools_Post::search_viewable_post()' );
        return DT_Posts::get_post_field_settings( 'contacts', $with_deleted_options = false, $load_from_cache = true );
    }
}

/**
 * Class Disciple_Tools_Groups_Post_Type
 * @deprecated version 1.0
 */
class Disciple_Tools_Groups_Post_Type {
    private static $_instance = null;

    /**
     * @return Disciple_Tools_Groups_Post_Type|null
     * @deprecated version 1.0
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    public function __construct() {}

    /**
     * @return mixed|void
     * @deprecated version 1.0
     */
    public function get_custom_fields_settings() {
        _deprecated_function( __CLASS__ . '::' . __FUNCTION__, '1.0', 'Disciple_Tools_Post::search_viewable_post()' );
        return DT_Posts::get_post_field_settings( 'groups', $with_deleted_options = false, $load_from_cache = true );
    }
}
