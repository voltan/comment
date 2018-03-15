<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt BSD 3-Clause License
 */

namespace Module\Comment\Model\Post;

use \Pi;

class RowGateway extends \Pi\Db\RowGateway\RowGateway
{
    public function save($rePopulate = true, $filter = true)
    {
        $return = parent::save($rePopulate, $filter);

        $this->flushHomepage();

        return $return;
    }

    public function delete()
    {
        $this->flushHomepage();

        return parent::delete(); // TODO: Change the autogenerated stub
    }

    public function flushHomepage()
    {
        /**
         * Flush homepage if current post is displayed in home
         */
        $blockComments = new \Module\Comment\Block\Block();
        $latestComments = $blockComments::post(array('not_by_root' => true, 'limit' => 3, 'avatar' => 'large'));

        foreach($latestComments['posts'] as $post){
            if(isset($post['id']) && $this->id == $post['id']){
                Pi::service('cache')->flushCacheByUrl('/', 'system');
            }
        }
    }
}
