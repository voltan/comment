<?php
/**
 * Pi Engine (http://piengine.org)
 *
 * @link            http://code.piengine.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://piengine.org
 * @license         http://piengine.org/license.txt BSD 3-Clause License
 */

namespace Module\Comment\Api;

use Pi;
use Pi\Application\Api\AbstractApi;

/**
 * Comment Event Handler
 *
 * @author Taiwen Jiang <taiwenjiang@tsinghua.org.cn>
 */
class Event extends AbstractApi
{
    /**
     * Comment post submission
     *
     * @param int $id
     */
    public function postsubmit($id)
    {
        return;
    }

    /**
     * Comment post publish
     *
     * @param int $id
     */
    public function postpublish($id)
    {
        // Clear cache for leading comments
        Pi::service('comment')->clearPagination($id);

        // Insert timeline item
        Pi::service('comment')->timeline($id);

        return;
    }

    /**
     * Comment post update
     *
     * @param int $id
     */
    public function postupdate($id)
    {
        // Clear cache for leading comments
        Pi::service('comment')->clearPagination($id);

        return;
    }

    /**
     * Comment post enable
     *
     * @param int|int[] $id
     */
    public function postenable($id)
    {
        // Clear cache for leading comments
        Pi::service('comment')->clearPagination($id);

        // Insert timeline item
        if (is_array($id)) {
            foreach ($id as $cid) {
                Pi::service('comment')->timeline($cid);
            }
        } else {
            Pi::service('comment')->timeline($id);
        }

        return;
    }

    /**
     * Comment post disable
     *
     * @param int|int[] $id
     */
    public function postdisable($id)
    {
        // Clear cache for leading comments
        Pi::service('comment')->clearPagination($id);
        Pi::service('comment')->timelineDelete($id);

        return;
    }

    /**
     * Comment post delete
     *
     * @param int|int[] $root
     */
    public function postdelete($id)
    {
        Pi::service('comment')->clearPagination($id, true);
        Pi::service('comment')->timelineDelete($id);
        return;
    }

}
