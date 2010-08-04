<?php

interface ezpRestAuthenticationStyle
{
    /**
     * Setting up the state to allow for later authentcation checks.
     *
     * @param ezcMvcRequest $request
     * @return void
     */
    public function setup( ezcMvcRequest $request );

    /**
     * Method to be run inside the runRequestFilters hook inside MvcTools.
     * 
     * This method should take care of seting up proper redirections to MvcTools
     *
     * @return void
     */
    public function authenticate( ezcMvcRequest $request );
}
?>