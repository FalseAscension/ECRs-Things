<?php


class ecr_DB {

    public $db_version = '1.0';

    function __construct() {}

    function create_table() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $sql = 
            "CREATE TABLE ecr_data (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                data_type varchar(255) NOT NULL,
                data text NOT NULL,
                slug varchar(255),
                PRIMARY KEY  (id)
            ) $charset_collate;";

        if ( ! function_exists('dbDelta') ) require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        dbDelta($sql);

        add_option('ecr_db_version', $this->db-version);
    }

    function update_table() {
        global $wpdb;

        if( $this->db_version == get_option('ecr_db_version') ) return; // Nothing to do here

        $charset_collate = $wpdb->get_charset_collate();

        $sql = 
            "CREATE TABLE ecr_data (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                data_type varchar(255) NOT NULL,
                data text NOT NULL,
                slug varchar(255),
                PRIMARY KEY  (id)
            ) $charset_collate;";

        if ( ! function_exists('dbDelta') ) require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        dbDelta($sql);

        update_option('ecr_db_version', $this->db_version);
    }

    function get_data_type($data_type) {
        global $wpdb;

        $query = $wpdb->prepare(
            "SELECT * FROM ecr_data
             WHERE data_type = %s;",
             $data_type
        );

        return $wpdb->get_results($query, ARRAY_A);
    }

    function get_data($slug) {
        global $wpdb;

        $query = $wpdb->prepare(
            "SELECT * FROM ecr_data
             WHERE slug = %s;",
             $slug
        );

        return $wpdb->get_results($query, ARRAY_A); // Should this return raw or JSON decoded data??
    }

    function get_slugs($data_type) { // Return a list of slugs for the given data type
        global $wpdb;

        $query = $wpdb->prepare(
            "SELECT slug FROM (
                SELECT MIN(id), slug FROM ecr_data
                WHERE data_type = %s
                GROUP BY slug
            ) AS forms;",
            $data_type
        );
        
        return $wpdb->get_results($query, ARRAY_A);
    }

    function insert_data($data_type, $data, $slug='') {
        global $wpdb;

        return $wpdb->insert('ecr_data',
            array(
                'data_type' => $data_type,
                'data' => $data,
                'slug' => $slug
            )
        );

        //return $wpdb->get_row('SELECT SCOPE_IDENTITY();');
    }
}

function ecr_db_install() {
    $ecrdb = new ecr_DB();
    $ecrdb->create_table();
}

register_activation_hook(__FILE__, 'ecr_db_install');

add_action('plugin_loaded', function(){
    $ecrdb = new ecr_DB();
    $ecrdb->update_table();
});
