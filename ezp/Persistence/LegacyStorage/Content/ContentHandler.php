<?php
/**
 * File containing the ContentHandler class
 *
 * @copyright Copyright (C) 1999-2011 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 *
 */

namespace ezp\Persistence\LegacyStorage\Content;
use ezp\Persistence\Content\Interfaces\ContentHandler as ContentHandlerInterface,
    ezp\Persistence\Content\ContentCreateStruct,
    ezp\Persistence\Content\ContentUpdateStruct,
    ezp\Content\Criteria\Criteria;

/**
 * The ContentHandler stores Content and ContentType objects.
 *
 * @version //autogentag//
 */
class ContentHandler implements ContentHandlerInterface
{
    /**
     * Creates a new Content entity in the storage engine.
     *
     * The values contained inside the $content will form the basis of stored
     * entity.
     *
     * Will contain always a complete list of fields.
     *
     * @param ContentCreateStruct $content Content creation struct.
     * @return ezp\Persistence\Content Content value object
     */
    public function create( ContentCreateStruct $content )
    {
        throw new Exception( "Not implemented yet." );
    }

    /**
     * Creates a new draft version from $contentId in $version.
     *
     * Copies all fields from $contentId in $srcVersion and creates a new
     * version of the referred Content from it.
     *
     * @param int $contentId
     * @param int|bool $srcVersion
     * @return ezp\Persistence\Content\Content
     */
    public function createDraftFromVersion( $contentId, $srcVersion )
    {
        throw new Exception( "Not implemented yet." );
    }

    /**
     * Returns the raw data of a content object identified by $id, in a struct.
     *
     * @param int $id
     * @return ezp\Persistence\Content Content value object
     */
    public function load( $id )
    {
        throw new Exception( "Not implemented yet." );
    }

    /**
     * Returns a list of object satisfying the $criteria.
     *
     * @param  Criteria $criteria
     * @param $offset
     * @param $limit
     * @param $sort
     * @return array(ezp\Persistence\Content) Content value object.
     */
    public function find( Criteria $criteria, $offset, $limit, $sort )
    {
        throw new Exception( "Not implemented yet." );
    }

    /**
     * Returns a single Content object found.
     *
     * Performs a {@link find()} query to find a single object. You need to
     * ensure, that your $criteria ensure that only a single object can be
     * retrieved.
     *
     * @param Criteria $criteria
     * @param mixed $offset
     * @param mixed $sort
     * @return ezp\Persistence\Content
     */
    public function findSingle( Criteria $criteria, $offset, $sort )
    {
        throw new Exception( "Not implemented yet." );
    }

    /**
     * Sets the state of object identified by $contentId and $version to $state.
     *
     * The $state can be one of STATUS_DRAFT, STATUS_PUBLISHED, STATUS_ARCHIVED.
     *
     * @param int $contentId
     * @param int $state
     * @param int $version
     * @see ezp\Content\Content
     * @return boolean
     */
    public function setState( $contentId, $state, $version )
    {
        throw new Exception( "Not implemented yet." );
    }

    /**
     * Sets the object-state of object identified by $contentId and $stateGroup to $state.
     *
     * The $state is the id of the state within one group.
     *
     * @param mixed $contentId
     * @param mixed $stateGroup
     * @param mixed $state
     * @return boolean
     * @see ezp\Content\Content
     */
    public function setObjectState( $contentId, $stateGroup, $state )
    {
        throw new Exception( "Not implemented yet." );
    }

    /**
     * Gets the object-state of object identified by $contentId and $stateGroup to $state.
     *
     * The $state is the id of the state within one group.
     *
     * @param mixed $contentId
     * @param mixed $stateGroup
     * @return mixed
     * @see ezp\Content\Content
     */
    public function getObjectState( $contentId, $stateGroup )
    {
        throw new Exception( "Not implemented yet." );
    }

    /**
     * Updates a content object entity with data and identifier $content
     *
     * @param ContentUpdateStruct $content
     * @return ezp\Persistence\Content
     */
    public function update( ContentUpdateStruct $content )
    {
        throw new Exception( "Not implemented yet." );
    }

    /**
     * Deletes all versions and fields, all locations (subtree), and all relations.
     *
     * Removes the relations, but not the related objects. Alle subtrees of the
     * assigned nodes of this content objects are removed (recursivley).
     *
     * @param int $contentId
     * @return boolean
     */
    public function delete( $contentId )
    {
        throw new Exception( "Not implemented yet." );
    }

    /**
     * Return the versions for $contentId
     *
     * @param int $contentId
     * @return array(Version)
     */
    public function listVersions( $contentId )
    {
        throw new Exception( "Not implemented yet." );
    }

    /**
     * Fetch a content value object containing the values of the translation for $languageCode.
     *
     * This method might use field filters, if they are designed and available
     * at a later point in time.
     *
     * @param int $contentId
     * @param string $languageCode
     * @return ezp\Persistence\Content\Content
     */
    public function fetchTranslation( $contentId, $languageCode )
    {
        throw new Exception( "Not implemented yet." );
    }
}
?>