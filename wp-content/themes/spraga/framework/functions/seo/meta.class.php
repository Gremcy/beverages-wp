<?php

namespace PS\Functions\Seo;

/**
 * Class Meta
 * @package PS\Functions\Seo
 */
class Meta {

    protected $separator;
    protected $blogname;

    /**
     * constructor
     */
    public function __construct() {
        $this->separator = ' - ';
        $this->blogname = get_option('blogname');
        //
        add_filter( 'wp_title', array($this, 'seo_title'), 100 ); // set seo
        add_filter( 'PS_get_context', array( $this, 'set_context' ) );
    }

    /**
     * SEO
     */
    private function get_seo($what){
        // get seo value from database

        /* SINGULAR POST */
        if(is_singular() && !is_page()){

            $post_type = get_post_type_object(get_post_type());
            // return
            $default = ($what=='title' ? get_the_title() . $this->separator . $post_type->labels->name . $this->separator . $this->blogname : '');
            $return = (get_field('seo_'.$what) ? get_field('seo_'.$what) : $default);

        }

        // BLOG
        elseif(is_page('blog') && get_query_var('section')){
            $blog_type = get_term_by('slug', get_query_var('section'), 'blog_type');

            // return
            $default = ($what=='title' ? (isset($blog_type->name) ? $blog_type->name : get_the_title()) . $this->separator . $this->blogname : '');
            $return = (get_field('seo_'.$what) ? get_field('seo_'.$what) : $default);
        }

        /* OTHER */
        else{

            $return = get_field('seo_'.$what);

        }

        /* RETURN */
        if($what=='title'){ // TITLE
            return $return;
        }elseif($what=='description'){ // DESCRIPTION
            return ($return ? $return : get_option('blogdescription'));
        }else{ // SEO-TEXT
            return $return;
        }
    }

    /**
     * set SEO
     */
    public function seo_title($title){
        $custom_title = $this::get_seo('title');
        if(is_front_page()){ // mainpage
            return ($custom_title ?: $this->blogname );
        }else{ // others
            return ($custom_title ?: $title . $this->separator . $this->blogname );
        }
    }

    /**
     * return SEO
     */
    public function set_context( $context ) {
        $context['seo_description'] = $this->get_seo('description');
        $context['seo_text'] = $this->get_seo('text');
        return $context;
    }

}