<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://mrkalathiya.wordpress.com/
 * @since      1.0.0
 *
 * @package    Contact_Form_Shortcode_Finder
 * @subpackage Contact_Form_Shortcode_Finder/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Contact_Form_Shortcode_Finder
 * @subpackage Contact_Form_Shortcode_Finder/admin
 * @author     Hardik Kalathiya <hardikkalathiya93@gmail.com>
 */
class Contact_Form_Shortcode_Finder_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

        add_action('admin_menu', array($this, 'wpdocs_register_shortcode_pages'));
        add_shortcode('wpdocs_shortcode_pages_callback', array($this, 'wpdocs_shortcode_pages_callback'));
    }

    public function wpdocs_register_shortcode_pages() {
        add_submenu_page(
                'wpcf7', 'Shortcode pages', 'Shortcode pages', 'manage_options', 'short-code-pages', array($this, 'wpdocs_shortcode_pages_callback'));
    }

    public function wpdocs_shortcode_pages_callback() {
        global $wpdb;
        $posts = get_posts(array(
            'post_type' => 'wpcf7_contact_form',
            'numberposts' => -1
        ));
        ?>
        <h1>Shortcode page/widget links</h1>
        <div class="main-wrap-shcode">
            <table>
                <tr class="heading"> 
                    <th>Form Title</th>
                    <th>Shortcode</th>
                    <th>To</th> 
                    <th>Pages Link</th>
                </tr>
                <?php
                $i = 1;
                foreach ($posts as $p) {
                    $shortcode = '[contact-form-7 id="' . $p->ID . '" title="' . $p->post_title . '"]';
                    ?>
                    <tr class="res-main-wrap"> 
                        <td>
                            <span><b><?php echo $p->post_title; ?></b></span>
                        </td>
                        <td>
                            <span>[contact-form-7 id="<?php echo $p->ID; ?>" title="<?php echo $p->post_title; ?>"]</span>
                        </td>
                        <td class="to">
                            <span>
                                <?php
                                $recipient = get_post_meta($p->ID, '_mail', true);
                                echo $recipient['recipient'];
                                ?>
                            </span>
                        </td> 
                        <td>
                            <?php
                            $tbl = $wpdb->base_prefix . 'posts';
                            $widget_find = $wpdb->base_prefix . 'options';
                            $shortcode = '[contact-form-7 id="' . $p->ID . '" title="' . $p->post_title . '"]';
                            $query = "SELECT * FROM $tbl WHERE post_content LIKE '%$shortcode%' AND post_status like 'publish'";
                            $widget_query = "SELECT * FROM $widget_find WHERE (option_value LIKE '%$shortcode%')";
                            $result = $wpdb->get_results($query);
                            $result_widget = $wpdb->get_results($widget_query);
                            $widget_found = '';
                            if (!empty($result_widget)) {
                                foreach ($result_widget as $widget) {
                                    $link = site_url() . '/wp-admin/widgets.php';
                                    $widget_found .= '<li class="shortcode-page-link"><a href=' . $link . ' target="_blank">Shortcode found in <b><i>Widget</i></b></a></li>';
                                }
                            } else {
                                $widget_found = '';
                            }
                            ?>					
                            <ul>
                                <?php
                                echo $widget_found;
                                if (!empty($result)) {
                                    foreach ($result as $page) {
                                        ?>
                                        <li class='shortcode-page-link'>
                                            <a href="<?php echo get_the_permalink($page->ID); ?>" target="_blank">
                                                <?php echo $page->post_title; ?>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <li class='shortcode-page-link' style="display: none;">
                                        <b><h3>-</h3></b>
                                    </li>
                                <?php } ?>
                            </ul>
                        </td>
                    </tr> 
                    <?php
                    $i++;
                }
                ?>
            </table>
        </div>
        <?php
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Contact_Form_Shortcode_Finder_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Contact_Form_Shortcode_Finder_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/contact-form-shortcode-finder-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Contact_Form_Shortcode_Finder_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Contact_Form_Shortcode_Finder_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/contact-form-shortcode-finder-admin.js', array('jquery'), $this->version, false);
    }

}
