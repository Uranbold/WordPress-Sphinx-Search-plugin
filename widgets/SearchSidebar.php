<?php
/**
 * SearcheSidebarWidget Class
 */
class SearchSidebarWidget extends WP_Widget
{
    /** constructor */
    function  SearchSidebarWidget()
    {
        $widget_ops = array('classname' => 'SearchSidebarWidget',
                            'description' => 'Sphinx search sidebar' );
        $this->WP_Widget('SearchSidebarWidget', 'Sphinx Search sidebar widget',
                $widget_ops);

        //parent::WP_Widget(false, $name = 'SphinxLatestSearchesWidget');
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance)
    {
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        echo $before_widget;
        if ( $title ) {
            echo $before_title . $title . $after_title;
        }
        $this->getSidebar();
        echo $after_widget;
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

    /** @see WP_Widget::form */

    function form($instance) {

        $title = !empty($instance['title']) ? esc_attr($instance['title']) : '';
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>">
            <?php _e('Title:'); ?>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>"
                   type="text" value="<?php echo $title; ?>" />
            </label></p>
        <?php

    }

    function getSidebar()
    {
        global $defaultObjectSphinxSearch;

	if ('true' == $defaultObjectSphinxSearch->frontend->params['search_posts'])
            $search_posts = "checked='checked'";
	else $search_posts = '';

	if ('true' == $defaultObjectSphinxSearch->frontend->params['search_pages'])
            $search_pages = "checked='checked'";
	else $search_pages = '';

	if ('true' == $defaultObjectSphinxSearch->frontend->params['search_comments'])
            $search_comments = "checked='checked'";
	else $search_comments = '';

	$search_sortby_relevance = $search_sortby_date = '';
	if (!empty($defaultObjectSphinxSearch->frontend->params['search_sortby']) &&
            $defaultObjectSphinxSearch->frontend->params['search_sortby'] == 'date'
            )
            $search_sortby_date = 'checked="true"';
	else
            $search_sortby_relevance = 'checked="false"';;

         require_once(SPHINXSEARCH_PLUGIN_DIR.'/templates/sphinx_search_bar.htm');
    }
}


