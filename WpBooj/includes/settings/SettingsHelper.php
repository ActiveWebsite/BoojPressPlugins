<?php
/**
 * Created by PhpStorm.
 * User: toddroper
 * Date: 8/23/18
 * Time: 2:18 PM
 */


class SettingsHelper
{
    /**
     * @var array | $sections | The sections for the WpBooj config page.
     * @TODO: Absctract to allow for this to be passed in so we can place config arrays in a more logical place.
     */
    private static $sections = array(
        array(
            'register' => true,
            'section' => 'wpbooj_popular_posts',
            'name' => "wpbooj_popular_orderby",
            'title' => "Popular Posts",
            'callback' => 'wpbooj_popular_posts_cb',
            'page' => 'wpbooj_options',
            'fields' => array(
                array(
                    'id' => 'wpbooj_field_popular_posts_orderby',
                    'title' => 'Order By',
                    'callback' => 'wpbooj_field_popular_orderby_cb',
                )
            )
        ),
        array(
            'register' => false,
            'name' => "wpbooj_popular_order",
            'page' => 'wpbooj_options',
            'section' => 'wpbooj_popular_posts',
            'fields' => array(
                array(
                    'id' => 'wpbooj_field_popular_posts_order',
                    'title' => '',
                    'callback' => 'wpbooj_field_popular_order_cb',
                )
            )
        ),
        array(
            'register' => true,
            'section' => 'wpbooj_ymal_posts',
            'title' => "You May Also Like Posts",
            'name' => "wpbooj_ymal_orderby",
            'callback' => 'wpbooj_ymal_posts_cb',
            'page' => 'wpbooj_options',
            'fields' => array(
                array(
                    'id' => 'wpbooj_ymal_posts_orderby',
                    'title' => '',
                    'callback' => 'wpbooj_field_ymal_orderby_cb',
                )
            )
        ),
        array(
            'register' => false,
            'name' => "wpbooj_ymal_order",
            'page' => 'wpbooj_options',
            'section' => 'wpbooj_ymal_posts',
            'fields' => array(
                array(
                    'id' => 'wpbooj_ymal_posts_order',
                    'title' => '',
                    'callback' => 'wpbooj_field_ymal_order_cb',
                )
            )
        ),
    );


    /**
     * @description Method registers the config sections for the WpBooj page.
     * @return void
     */
    public static function registerSections()
    {
        foreach (self::$sections as $opts)
        {
            register_setting( "wpbooj_options", $opts['name']);
            if( $opts['register'] === true )
            {
                // register a new section in the "wpbooj" page
                add_settings_section(
                    $opts['section'],
                    __( $opts['title'], $opts['page']),
                    $opts['callback'],
                    $opts['page']
                );
            }

            if(isset($opts['fields']) && !empty($opts['fields']))
            {
                foreach($opts['fields'] as $field)
                {
                    self::addFieldToPage($field, $opts['section'], $opts['page']);
                }
            }
        }
    }


    /**
     * @description Method adds field to section.
     * @param array | $field | The field array.
     * @param string | $section | The string representing the registered section.
     * @param string | $page | The page string.
     * @return void
     */
    public static function addFieldToPage($field, $section, $page)
    {
        add_settings_field(
            $field['id'],
            __( $field['title'], $field['page'] ),
            $field['callback'],
            $page,
            $section,
            array (
                'label_for' => $field['id'],
                'class' => 'wpbooj_row',
                'wpbooj_custom_data' => 'custom',
            )
        );
    }


}