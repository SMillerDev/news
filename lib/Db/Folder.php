<?php
/**
 * Nextcloud - News
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author    Alessandro Cosentino <cosenal@gmail.com>
 * @author    Bernhard Posselt <dev@bernhard-posselt.com>
 * @copyright 2012 Alessandro Cosentino
 * @copyright 2012-2014 Bernhard Posselt
 */

namespace OCA\News\Db;

use \OCP\AppFramework\Db\Entity;

/**
 * @method integer getId()
 * @method void setId(integer $value)
 * @method string getUserId()
 * @method void setUserId(string $value)
 * @method string getName()
 * @method void setName(string $value)
 * @method integer getParentId()
 * @method void setParentId(integer $value)
 * @method boolean getOpened()
 * @method void setOpened(boolean $value)
 * @method integer getDeletedAt()
 * @method void setDeletedAt(integer $value)
 * @method string getLastModified()
 * @method void setLastModified(string $value)
 */
class Folder extends Entity implements IAPI, \JsonSerializable
{

    use EntityJSONSerializer;

    protected $parentId;
    protected $name;
    protected $userId;
    protected $opened;
    protected $deletedAt;
    protected $lastModified;

    public function __construct()
    {
        $this->addType('parentId', 'integer');
        $this->addType('opened', 'boolean');
        $this->addType('deletedAt', 'integer');
    }

    /**
     * Turns entitie attributes into an array
     */
    public function jsonSerialize() 
    {
        return $this->serializeFields(
            [
            'id',
            'parentId',
            'name',
            'userId',
            'opened',
            'deletedAt',
            ]
        );
    }

    public function toAPI() 
    {
        return $this->serializeFields(
            [
            'id',
            'name'
            ]
        );
    }
}