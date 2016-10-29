<?php

/*
 * This file is part of Hiject.
 *
 * Copyright (C) 2016 Hiject Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hiject\Api\Authorization;

use JsonRPC\Exception\AccessDeniedException;
use Hiject\Core\Base;

/**
 * Class ProcedureAuthorization
 */
class ProcedureAuthorization extends Base
{
    private $userSpecificProcedures = array(
        'getMe',
        'getMyDashboard',
        'getMyActivityStream',
        'createMyPrivateProject',
        'getMyProjectsList',
        'getMyProjects',
        'getMyOverdueTasks',
    );

    public function check($procedure)
    {
        if (! $this->userSession->isLogged() && in_array($procedure, $this->userSpecificProcedures)) {
            throw new AccessDeniedException('This procedure is not available with the API credentials');
        }
    }
}
