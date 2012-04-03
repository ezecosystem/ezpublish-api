<?php
/**
 * File containing the BaseTest class
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */

namespace eZ\Publish\API\REST\Server\Generator;
use eZ\Publish\API\REST\Server\Generator;

class Json extends Generator
{
    /**
     * Data structure which is build during visiting;
     *
     * @var array
     */
    protected $json;

    /**
     * Start document
     *
     * @param mixed $data
     * @return void
     */
    public function startDocument( $data )
    {
        $this->json = new Json\Object();
    }

    /**
     * End document
     *
     * Returns the generated document as a string.
     *
     * @param mixed $data
     * @return string
     */
    public function endDocument( $data )
    {
        $this->json = $this->convertArrayObjects( $this->json );
        return json_encode( $this->json );
    }

    /**
     * Convert ArrayObjects to arrays
     *
     * Recursively convert all ArrayObjects into arrays in the full data
     * structure.
     *
     * @param mixed $data
     * @return mixed
     */
    protected function convertArrayObjects( $data )
    {
        if ( $data instanceof Json\ArrayObject )
        {
            // @TODO: Check if we need to convert arrays with only one single
            // element into non-arrays /cc cba
            $data = $data->getArrayCopy();
            foreach ( $data as $key => $value )
            {
                $data[$key] = $this->convertArrayObjects( $value );
            }
        }
        elseif ( $data instanceof Json\Object )
        {
            foreach ( $data as $key => $value )
            {
                $data->$key = $this->convertArrayObjects( $value );
            }
        }

        return $data;
    }

    /**
     * Start element
     *
     * @param string $name
     * @return void
     */
    public function startElement( $name )
    {
        $object = new Json\Object( $this->json );

        if ( $this->json instanceof Json\ArrayObject )
        {
            $this->json[] = $object;
            $this->json = $object;
        }
        else
        {
            $this->json->$name = $object;
            $this->json = $object;
        }

        $this->startAttribute( "media-type", $this->getMediaType( $name, 'json' ) );
        $this->endAttribute( "media-type" );
    }

    /**
     * End element
     *
     * @param string $name
     * @return void
     */
    public function endElement( $name )
    {
        $this->json = $this->json->getParent();
    }

    /**
     * Start value element
     *
     * @param string $name
     * @param string $value
     * @return void
     */
    public function startValueElement( $name, $value )
    {
        $this->json->$name = $value;
    }

    /**
     * End value element
     *
     * @param string $name
     * @return void
     */
    public function endValueElement( $name )
    {
    }

    /**
     * Start list
     *
     * @param string $name
     * @return void
     */
    public function startList( $name )
    {
        $array = new Json\ArrayObject( $this->json );

        $this->json->$name = $array;
        $this->json = $array;
    }

    /**
     * End list
     *
     * @param string $name
     * @return void
     */
    public function endList( $name )
    {
        $this->json = $this->json->getParent();
    }

    /**
     * Start attribute
     *
     * @param string $name
     * @param string $value
     * @return void
     */
    public function startAttribute( $name, $value )
    {
        $this->json->{'_' . $name} = $value;
    }

    /**
     * End attribute
     *
     * @param string $name
     * @return void
     */
    public function endAttribute( $name )
    {
    }
}

