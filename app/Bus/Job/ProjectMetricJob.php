<?php

/*
 * This file is part of Hiject.
 *
 * Copyright (C) 2016 Hiject Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hiject\Bus\Job;

/**
 * Class ProjectMetricJob
 */
class ProjectMetricJob extends BaseJob
{
    /**
     * Set job parameters
     *
     * @access public
     * @param  integer $projectId
     * @return $this
     */
    public function withParams($projectId)
    {
        $this->jobParams = array($projectId);
        return $this;
    }

    /**
     * Execute job
     *
     * @access public
     * @param  integer $projectId
     */
    public function execute($projectId)
    {
        $this->logger->debug(__METHOD__.' Run project metrics calculation');
        $now = date('Y-m-d');

        $this->projectDailyColumnStatsModel->updateTotals($projectId, $now);
        $this->projectDailyStatsModel->updateTotals($projectId, $now);
    }
}
