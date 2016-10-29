<?php

/*
 * This file is part of Hiject.
 *
 * Copyright (C) 2016 Hiject Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hiject\Bus\Subscriber;

use Hiject\Core\User\UserProfile;
use Hiject\Bus\Event\UserProfileSyncEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class LdapUserPhotoSubscriber
 */
class LdapUserPhotoSubscriber extends BaseSubscriber implements EventSubscriberInterface
{
    /**
     * Get event listeners
     *
     * @static
     * @access public
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            UserProfile::EVENT_USER_PROFILE_AFTER_SYNC => 'syncUserPhoto',
        );
    }

    /**
     * Save the user profile photo from LDAP to the object storage
     *
     * @access public
     * @param  UserProfileSyncEvent $event
     */
    public function syncUserPhoto(UserProfileSyncEvent $event)
    {
        if (is_a($event->getUser(), 'Hiject\User\LdapUserProvider')) {
            $profile = $event->getProfile();
            $photo = $event->getUser()->getPhoto();

            if (empty($profile['avatar_path']) && ! empty($photo)) {
                $this->logger->info('Saving user photo from LDAP profile');
                $this->avatarFileModel->uploadImageContent($profile['id'], $photo);
            }
        }
    }
}
