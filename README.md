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

So if you wanted to add a feature such as archive, you would need to define an array with these options:

            $default_options = array(
                'has_archive' => true
            );

And pass it to the constructor function.

To create a custom post type, the code that you would use would be:

        $events = new STContentType( 'events', $default_options, array('singular_name'=> 'Event', 'plural_name' => 'Events')); 

# Version History        

### 1.0
* Initial Release

### 1.0.1 
* Fixed Read Me File




