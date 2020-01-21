<?php

class ecr_Events
{
    public $postType = "ecr_event";
    public $taxonomyType = "ecr_event_type";

    function __construct(){}

    function registration() {
        // Post Type
        register_post_type($this->postType,
            array(
                'labels' => array(
                    'name' => "Events",
                    'singular_name' => "Event",
                    'add_new_item' => "Add new",
                    'edit_item' => "Edit"
                ),
                'exclude_from_search' => false,
                'publicly_queryable' => true,
                'show_ui' => true,
                'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
                'query_var' => $this->postType,
                'hierarchial' => false,
                'show_in_rest' => true,
                'menu_icon' => "dashicons-calendar-alt",
                'rewrite' => array(
                    'slug' => "event",
                    'with_front' => false,
                )
            )
        );

        // Taxonomies
        register_taxonomy(
            $this->taxonomyType,
            $this->postType,
            array(
                'label' => "Event Type",
                'show_in_rest' => true,
                'hierarchal' => false,
                'rewrite' => array(
                    'slug' => "event-type"
                )
            )
        );
    }

    function buildQuery($from='', $to='', $type='', $keywords='', $args=array()) {
        $metaQuery = array();
        $taxQuery = array();

        if($from === '') $from = current_time('mysql');
        $metaQuery[] = array(
            'key' => 'ecr_event_details_start',
            'value' => $from,
            'compare' => '>=',
            'type' => 'DATE'
        );

        if($to !== '') {
            $metaQuery[] = array(
                'key' => 'ecr_event_details_end',
                'value' => $to,
                'compare' => '<=',
                'type' => 'DATE'
            );
        }

        if($type !== '') {
            $taxQuery[] = array(
                'taxonomy' => $this->taxonomyType,
                'field' => 'slug',
                'terms' => $type
            );
        }

        if($keywords !== '') {
            $args['s'] = $keywords;
        }

        if(count($metaQuery) > 1) $metaQuery['relation'] = "AND";
        if(count($taxQuery) > 1) $taxQuery['relation'] = "AND";

        $args['meta_query'] = $metaQuery;
        $args['tax_query'] = $taxQuery;

        return $this->query($args);
    }

    function query($args=array()) {
        $wpQueryArgs = array(
            'post_type' => $this->postType,
            'posts_per_page' => -1,
            'meta_key' => 'ecr_event_details_start',
            'orderby' => 'meta_value',
            'order' => 'ASC'
        );

        return array_merge($wpQueryArgs, $args);
    }

    function addThumbnails(&$events) {
        foreach ($events as &$event) {
            $event->thumbnail = new TimberImage(get_the_post_thumbnail_url($event->id));
        }
        return $events;
    }
    
    function setEventInfo(&$event) {
        $event->location = $event->custom['ecr_event_details_location'];
        $event->postcode = $event->custom['ecr_event_details_postcode'];
        $event->start = $event->custom['ecr_event_details_start'];
        $event->end = $event->custom['ecr_event_details_end'];
    }

    function setInfo(&$events) {
        foreach ($events as &$event) {
            $this->setEventInfo($event);
        }
        return $events;
    }

    function addDistance(&$events, $fromPostcode) {
        foreach ($events as &$event) {
            $event->distance = distanceBetweenPostcodes($fromPostcode, $event->custom['ecr_event_details_postcode']);
        }
        return $events;
    }

    function getEvents($wpQueryArgs=null) {
        if($wpQueryArgs === null) $wpQueryArgs = $this->buildQuery();

        $events = Timber::get_posts($wpQueryArgs);
        $this->addThumbnails($events);
        $this->setInfo($events);

        return $events;
    }

}
add_action('init', function(){
    $events = new ecr_Events;
    $events->registration();
});
