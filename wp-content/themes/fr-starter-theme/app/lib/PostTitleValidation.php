<?php
if (!class_exists('PostTitleValidation')) :

    class PostTitleValidation
    {

        public function __construct()
        {
            add_action( 'edit_form_advanced', [$this, 'ValidateTitle'] );
            add_action( 'edit_page_form', [$this, 'ValidateTitle'], 10, 4);
        }


        // Validate post title 
        public function ValidateTitle($post) {
            // List of post types that we want to require post titles for.
            $post_types = array( 
                'post',
                'camp', 
                'after-school-program',
                'team-member'
                );

            // If the current post is not one of the chosen post types, exit this function.
            if ( ! in_array( $post->post_type, $post_types ) ) {
                return;
            }

            ?>
            <script type='text/javascript'>
                ( function ( $ ) {	
                    $( document ).ready( function () {
                    //Require post title when adding/editing Project Summaries
                    $( 'body' ).on( 'submit.edit-post', '#post', function () {
                    // If the title isn't set
                    if ( $( "#title" ).val().replace( / /g, '' ).length === 0 ) {
                        // Show the alert
                        if ( !$( "#title-required-msj" ).length ) {
                            $( "#titlewrap" )
                            .append( '<div id="title-required-msj" style="background: #ffe6e6; color: #cc2727;border-color: #d12626;padding: 10px;border-left: 3px solid;margin-top:10px"><em>Title is required.</em></div>' );
                            
                        }
                        // Hide the spinner
                        $( '#major-publishing-actions .spinner' ).hide();
                        // The buttons get "disabled" added to them on submit. Remove that class.
                        $( '#major-publishing-actions' ).find( ':button, :submit, a.submitdelete, #post-preview' ).removeClass( 'disabled' );
                        // Focus on the title field.
                        $( "#title" ).focus();
                        return false;
                    }
                });
                });
                }( jQuery ) );
            </script>
            <?php

        }
        
    }
    /**
     * Initialize class
     */
    global $PostTitleValidation;
    $PostTitleValidation = new \PostTitleValidation();
endif;
