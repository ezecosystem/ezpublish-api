<?php
/**
 * File containing the StorageFieldValue class
 *
 * @copyright Copyright (C) 1999-2011 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 *
 */

namespace ezp\Persistence\LegacyStorage\Content;

use ezp\Persistence\AbstractValueObject;

class StorageFieldValue extends AbstractValueObject
{
    /**
     * Float data.
     *
     * @var float
     */
    public $dataFloat;

    /**
     * Integer data.
     *
     * @var int
     */
    public $dataInt;

    /**
     * Text data.
     *
     * @var string
     */
    public $dataText;

    /**
     * Integer sort key.
     *
     * @var int
     */
    public $sortKeyInt;

    /**
     * Text sort key.
     *
     * @var string
     */
    public $sortKeyString;
}