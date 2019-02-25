# scorpiotek-cpt-factory
Simplifies the creation of Custom Post Types by using a factory model with default options

# Instructions

* Activate this plugin as any other WordPress plugin.

* From where you would like to define your CPT, ideally your functions.php file in your theme include the namespace:

        // Depends on 'ScorpioTek Content Type Factory' plugin
        use \ScorpioTek\WordPress\Util\CPT\ContentType as STContentType;

The default options for the post are the following:

            'public' => true,
            'supports' => array('title', 'editor', 'revisions', 'thumbnail')

To create a type called cycling-trips and change its slug, your code would be something like this:

$edb_cycling_trip = new ContentType('edb_cycling_trip',
                                        array(
                                        'has_archive' => true,
                                        'menu_icon' => 'dashicons-palmtree',
                                        'rewrite' => array(
                                                'slug' => 'cycling-trips',
                                        )
                                        ),
                                        array(
                                        'singular_name'=> 'Cycling Trip',
                                        'plural_name' => 'Cycling Trips'
                                        )
                                );

# Version History

## 1.0.2 - February 19, 2019

* Modified Read me file.
* Fixed version number of plugin.

## 1.0.1 
* Fixed Read Me File

## 1.0
* Initial Release






