<?php

/*
  Plugin Name: Wp plugin boilerplate
  Plugin URI: http://www.24hr.se/
  Description: A boilerplate for creating a plugin
  Version: 1.0
  Author: Erik Johansson
  License: GPL2
 */

/*  Copyright 2011  Erik Johansson  (email : erik.johansson@24hr.se)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

class CustomPlugin {
    public static $CustomPluginDBVersion = "0.01";
    public static $tables = array(
        "CustomDB1" => "custom_db_table1",
        "CustomDB2" => "custom_db_table2"
    );
    public static $singletonRef = NULL;
    public $tableNameChats;
    public $tableNameQuestions;
    private $wpdb;
    public $blog_id;

    public static function getInstance() {
        if (self::$singletonRef == NULL) {
            self::$singletonRef = new CustomPlugin();
        }
        return self::$singletonRef;
    }

    public function __construct($blog_id = null) {
        if ($blog_id != null) {
            $this->blog_id = $blog_id;
        }
        global $wpdb;
        $this->wpdb = $wpdb;
        //Always use same tables, Use the first blogs (id: 1) table prefix.
        $wpdb->prefix = $wpdb->get_blog_prefix(1);
        $this->tableNameChats = $this->wpdb->prefix . CustomPlugin::$tables['CustomDB1'];
        $this->tableNameQuestions = $this->wpdb->prefix . CustomPlugin::$tables['CustomDB2'];
    }

    public static function install() {
        global $wpdb;
        $installed_ver = get_option("CustomPluginDBVersion");
        if ($installed_ver != CustomPlugin::$CustomPluginDBVersion)
        {
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            $table_name = $wpdb->prefix . CustomPlugin::$tables['CustomDB1'];
            $sql = "CREATE TABLE " . $table_name . " (
    	        id mediumint(9) NOT NULL AUTO_INCREMENT,
                blog_id mediumint(9) NULL,
    	        createDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    	        stopDate datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
    	        open TINYINT NOT NULL,
    	        user VARCHAR(300) NOT NULL,
    	        title VARCHAR(300) NOT NULL,
    	        text VARCHAR (3000) NOT NULL,
				UNIQUE KEY id (id)
            );";
            dbDelta($sql);
            $table_name = $wpdb->prefix . CustomPlugin::$tables['CustomDB2'];
            $sql = "CREATE TABLE " . $table_name . " (
    	        id mediumint(9) NOT NULL AUTO_INCREMENT,
				chat_id mediumint(9) NOT NULL,    
				name VARCHAR(300) NOT NULL,	            	        
				question VARCHAR(3000) NOT NULL,
    	        answer VARCHAR(3000) NOT NULL,
				createDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				UNIQUE KEY id (id)
            );";
            dbDelta($sql);
            update_option("CustomPluginDBVersion", CustomPlugin::$CustomPluginDBVersion);
        }
    }

    public static function update() {
        $installed_ver = get_option("CustomPluginDBVersion");
        if ($installed_ver != CustomPlugin::$CustomPluginDBVersion) {
            CustomPlugin::install();
        }
    }

    public static function setRequiredReferences() {
        //// css
        //wp_register_style('ExpertChatAdminCss', plugins_url('css/style.css', __FILE__));
        //wp_register_script('yoohoo', 'http://code.jquery.com/jquery-1.7.2.min.js');
        //// load script
        //wp_register_script('ExpertChatModal', plugins_url('/js/jquery.simplemodal.1.4.1.min.js', __FILE__));
        //wp_register_script('Placeholder', plugins_url('/js/jquery.placeholder.js', __FILE__));     
    } 
}

register_activation_hook(__FILE__, 'CustomPlugin::install');
add_action('plugins_loaded', 'CustomPlugin::update');
add_action('admin_menu', 'CustomPlugin::setRequiredReferences');
add_action('network_admin_menu', 'CustomPlugin::setRequiredReferences');

// load admin page
require_once('wp-plugin-boilerplate-admin.php');