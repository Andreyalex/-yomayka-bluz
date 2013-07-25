<?php
/**
 * @author   Anton Shevchuk
 * @created  10.10.11 16:48
 */
namespace Application;

return
/**
 * @privilege View
 *
 * @return \closure
 */
function () use ($view) {
    /**
     * @var \Bluz\Application $this
     */
    $this->getLayout()->setTemplate('dashboard.phtml');
    $this->getLayout()->breadCrumbs(
        [
            $view->ahref('Dashboard', ['dashboard', 'index']),
            $view->ahref('ACL', ['acl', 'index']),
            __('Users'),
        ]
    );

    $view->users = $this->getDb()->fetchObjects(
        'SELECT u.*, GROUP_CONCAT( ar.`name` SEPARATOR ", " ) AS rolesList
        FROM users u, acl_roles ar, acl_users_roles aur
        WHERE
            u.`id` = aur.`userId`
        AND ar.`id` = aur.`roleId`
        GROUP BY u.id',
        [],
        '\Application\Users\Row'
    );
};
