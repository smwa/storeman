All calls except for POST /api/?sessions and POST /api/?users require the cookie **sessionid**

* /api/?sessions
    * POST
        * Requires
            * email
            * password
        * Returns
            * sessionid
        * Side Effects
            * Sets cookie sessionid
    * DELETE /api/?sessions
        * Side Effects
            * Deletes cookie sessionid
* /api/?users
	* GET
		* Returns
			* id
			* email
	* POST
		* Requires
			* email
			* password
		* Returns
			* id
			* email
	* PUT
		* Requires
			* oldpassword - The user's current password
			* password - The user's new password
		* Returns
			* id
			* email
	* DELETE
		* Requires
			* password
* /api/?locations
    * GET
        * Returns
            * array
                * id
                * title
    * POST
        * Requires
            * title
        * Optional
            * description
        * Returns
            * id
            * user - User's ID
            * title
            * description
* /api/?locations/{id}
    * GET
        * Returns
            * id
            * user - User's ID
            * title
            * description
    * PUT
        * Requires
            * title
        * Optional
            * description
        * Returns
            * id
            * user - User's ID
            * title
            * description
    * DELETE
* /api/?containers
    * GET
        * Returns
            * Array
                * id
                * title
                * location - ID of location
    * POST
        * Requires
            * title
        * Optional
            * location - ID of location
        * Returns
            * id
            * title
            * location
* /api/?containers/{id}
    * GET
        * Returns
            * id
            * title
            * location
    * PUT
        * Requires
            * title
        * Optional
            * location - ID of location
        * Returns
            * id
            * title
            * location
    * DELETE
* /api/?items
    * GET
        * Returns
            * Array
                * id
                * title
                * location - ID of location
                * container - ID of container
    * POST
        * Requires
            * title
        * Optional
            * location - ID of location
            * container - ID of container
        * Returns
            * id
            * title
            * location - ID of location
            * container - ID of container
* /api/?items/{id}
    * GET
        * Returns
            * id
            * title
            * location - ID of location
            * container - ID of container
    * PUT
        * Requires
            * title
        * Optional
            * location - ID of location
            * container - ID of container
        * Returns
            * id
            * title
            * location
    * DELETE
* /api/?data
    * GET
        * Returns
            * Downloaded file, to be documented - All user data
    * POST
        * Not yet implemented
* /api/?containerimages/{container_id}
    * GET
        * Returns
            * content-type header for image
            * image data
    * POST
        * Requires
            * File upload: 'file'
        * Side Effects
            * Deletes other images on container
    * DELETE
        * Side Effects
            * Deletes all images on container
* /api/?itemimages/{item_id}
    * GET
        * Returns
            * content-type header for image
            * image data
    * POST
        * Requires
            * File upload: 'file'
        * Side Effects
            * Deletes other images on item
    * DELETE
        * Side Effects
            * Deletes all images on item
