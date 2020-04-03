<?php

/**
 * This is the model for singular posts.
 */
class Single extends MiddleModel {

    /**
     * This returns the current post
     *
     * @return array|null|WP_Post
     */
    public function Content() {
        return get_post( get_the_ID() );
    }
}