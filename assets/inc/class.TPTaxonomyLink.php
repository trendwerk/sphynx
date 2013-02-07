<?php
/**
 * A class that allows developers to easily link the content of a post type to taxonomy terms
 */

/**
 * @class TPTaxonomyLink
 *
 * Links the content of a post type to a taxonomy
 *
 * @param string $post_type Name of the post type
 * @param string $taxonomy Name of the taxonomy
 */
class TPTaxonomyLink {
	var $post_type;
	var $taxonomy;
	
	/**
	 * Constructor
	 */
	function __construct($post_type,$taxonomy) {
		$this->post_type = $post_type;
		$this->taxonomy = $taxonomy;
		
		//Add or update a term
		add_action('save_post',array($this,'update'));
		
		//Recover a term
		add_action('untrashed_post',array($this,'update'));
		
		//Delete a term
		add_action('trashed_post',array($this,'delete'));
	}
	
	/**
	 * Add or update a term in our taxonomy
	 *
	 * @param int $post_id The posts ID that has to be linked to our taxonomy
	 */
	function update($post_id) {
		if(!wp_is_post_revision($post_id) && !wp_is_post_autosave($post_id)) {
			$post = get_post($post_id);
			
			if($post->post_type == $this->post_type && $post->post_status != 'auto-draft') :
				if($term_id = get_post_meta($post->ID,'term_id',true)) :
					//This post is already linked to a term, let's see if it still exists
					$term = get_term($term_id,$this->taxonomy);
					
					if($term) :
						//It exists, update optional changes
						wp_update_term($term_id,$this->taxonomy,array(
							'name' => $post->post_title,
							'slug' => $post->post_name
						));
						return;
					endif;
				endif;
				
				//If the code made it here, either the term link didn't exist or still has to be created
				//Either way, create a new term link!
				$term = wp_insert_term($post->post_title,$this->taxonomy,array(
					'slug' => $post->post_name
				));
				if(!is_wp_error($term)) update_post_meta($post->ID,'term_id',$term['term_id']);
			endif;
		}
	}
	
	/**
	 * Delete a term
	 *
	 * @param int $post_id The posts ID which taxonomy term has to be removed
	 */
	function delete($post_id) {
		if(!wp_is_post_revision($post_id)) {
			$post = get_post($post_id);
			
			if($post->post_type == $this->post_type) :
				if($term_id = get_post_meta($post->ID,'term_id',true)) :
					//The post is linked to a term, delete it!
					$term = get_term($term_id,$this->taxonomy);
					
					if($term) :
						//The linked term still exists, now really delete.
						wp_delete_term($term_id,$this->taxonomy);
					endif;
				endif;
			endif;
		}
	}
	
	/**
	 * @abstract Convenience functions
	 */
	
	/**
	 * Retrieve the term or part of it that is linked to a certain post.
	 * This function can be used to easily get the term ID or slug to filter on posts which this post is linked to (using WP_Query).
	 *
	 * @param int $post_id The ID of the post
	 * @param string $taxonomy The taxonomy where the term should be in
	 * @param string $part Optional. The part of the term to return
	 */
	function get_term($post_id,$taxonomy,$part='') {
		if($post_id && $taxonomy) :
			$term = get_term(get_post_meta($post_id,'term_id',true),$taxonomy);
			
			if($term && !is_wp_error($term)) :
				if($part) return $term->$part;
				return $term;
			endif;
		endif;
	}
	
	/**
	 * Retrieve the terms or part of the terms which are linked to a certain post.
	 * This function can be used to get all terms (or maybe just the ID's) which can be used to filter
	 * and retrieve all posts which are linked to the current post (using WP_Query).
	 *
	 * @param int $post_id The ID of the post
	 * @param string $taxonomy The taxonomy of which to collect the 
	 * @param string $part Optional. The part of the terms to return
	 */
	function get_terms($post_id,$taxonomy,$part='') {
		if($post_id && $taxonomy) :
			$terms = wp_get_post_terms($post_id,$taxonomy);
			
			if($terms) :
				//Return complete objects
				if(!$part) return $terms;
				
				//Return part of the terms
				$terms_part = array();
				foreach($terms as $term) :
					$terms_part[] = $term->$part;
				endforeach;
				
				return $terms_part;
			endif;
		endif;
	}
}
?>