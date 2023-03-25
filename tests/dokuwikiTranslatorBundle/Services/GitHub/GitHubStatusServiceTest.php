<?php

namespace Tests\dokuwikiTranslatorBundle\Services\GitHub;

use App\Services\GitHub\GitHubStatusService;
use PHPUnit\Framework\TestCase;

/**
 * Dummy class for the service
 */
class GitHubStatusServiceExtend extends GitHubStatusService {
    public function testCheckResponse($content) {
        return $this->checkResponse($content);
    }
}

class GitHubStatusServiceTest extends TestCase {

    public function testCheckResponseGood() {
        $service = new GitHubStatusServiceExtend();

        $content = '{"page":{"id":"kctbh9vrtdwd","name":"GitHub","url":"https://www.githubstatus.com","time_zone":"Etc/UTC","updated_at":"2019-04-17T18:34:22.610Z"},"components":[{"id":"8l4ygp009s5s","name":"Git Operations","status":"operational","created_at":"2017-01-31T20:05:05.370Z","updated_at":"2019-04-01T13:31:10.941Z","position":1,"description":"Performance of git clones, pulls, pushes, and associated operations","showcase":false,"group_id":null,"page_id":"kctbh9vrtdwd","group":false,"only_show_if_degraded":false},{"id":"brv1bkgrwx7q","name":"API Requests","status":"operational","created_at":"2017-01-31T20:01:46.621Z","updated_at":"2019-03-12T16:25:03.772Z","position":2,"description":"Requests for GitHub APIs","showcase":false,"group_id":null,"page_id":"kctbh9vrtdwd","group":false,"only_show_if_degraded":false},{"id":"kr09ddfgbfsf","name":"Issues, PRs, Dashboard, Projects","status":"operational","created_at":"2017-01-31T20:01:46.638Z","updated_at":"2019-04-11T17:05:46.862Z","position":3,"description":"Web requests for github.com UI and services","showcase":false,"group_id":null,"page_id":"kctbh9vrtdwd","group":false,"only_show_if_degraded":false},{"id":"0l2p9nhqnxpd","name":"Visit www.githubstatus.com for more information","status":"operational","created_at":"2018-12-05T19:39:40.838Z","updated_at":"2019-01-15T23:11:22.604Z","position":4,"description":null,"showcase":false,"group_id":null,"page_id":"kctbh9vrtdwd","group":false,"only_show_if_degraded":false},{"id":"5bfcr2x9x8kc","name":"Notifications","status":"operational","created_at":"2018-01-26T20:01:14.837Z","updated_at":"2019-03-28T10:35:44.177Z","position":5,"description":"Email and webhook delivery for GitHub notifications","showcase":false,"group_id":null,"page_id":"kctbh9vrtdwd","group":false,"only_show_if_degraded":false},{"id":"04c28ykz2c5m","name":"Gists","status":"operational","created_at":"2018-01-10T23:47:34.474Z","updated_at":"2019-01-15T23:11:22.612Z","position":6,"description":"Web service requests for gists","showcase":false,"group_id":null,"page_id":"kctbh9vrtdwd","group":false,"only_show_if_degraded":false},{"id":"vg70hn9s2tyj","name":"GitHub Pages","status":"operational","created_at":"2017-01-31T20:04:33.923Z","updated_at":"2019-04-13T17:58:34.132Z","position":7,"description":"Frontend application and API servers for Pages builds","showcase":false,"group_id":null,"page_id":"kctbh9vrtdwd","group":false,"only_show_if_degraded":false}],"incidents":[],"scheduled_maintenances":[],"status":{"indicator":"none","description":"All Systems Operational"}}';

        $this->assertTrue($service->testCheckResponse($content));
    }

    public function testCheckResponseDegraded() {
        $service = new GitHubStatusServiceExtend();

        $content = '{"page":{"id":"kctbh9vrtdwd","name":"GitHub","url":"https://www.githubstatus.com","time_zone":"Etc/UTC","updated_at":"2019-04-17T18:34:22.610Z"},"components":[{"id":"8l4ygp009s5s","name":"Git Operations","status":"operational","created_at":"2017-01-31T20:05:05.370Z","updated_at":"2019-04-01T13:31:10.941Z","position":1,"description":"Performance of git clones, pulls, pushes, and associated operations","showcase":false,"group_id":null,"page_id":"kctbh9vrtdwd","group":false,"only_show_if_degraded":false},{"id":"brv1bkgrwx7q","name":"API Requests","status":"degraded_performance","created_at":"2017-01-31T20:01:46.621Z","updated_at":"2019-03-12T16:25:03.772Z","position":2,"description":"Requests for GitHub APIs","showcase":false,"group_id":null,"page_id":"kctbh9vrtdwd","group":false,"only_show_if_degraded":false},{"id":"kr09ddfgbfsf","name":"Issues, PRs, Dashboard, Projects","status":"operational","created_at":"2017-01-31T20:01:46.638Z","updated_at":"2019-04-11T17:05:46.862Z","position":3,"description":"Web requests for github.com UI and services","showcase":false,"group_id":null,"page_id":"kctbh9vrtdwd","group":false,"only_show_if_degraded":false},{"id":"0l2p9nhqnxpd","name":"Visit www.githubstatus.com for more information","status":"operational","created_at":"2018-12-05T19:39:40.838Z","updated_at":"2019-01-15T23:11:22.604Z","position":4,"description":null,"showcase":false,"group_id":null,"page_id":"kctbh9vrtdwd","group":false,"only_show_if_degraded":false},{"id":"5bfcr2x9x8kc","name":"Notifications","status":"operational","created_at":"2018-01-26T20:01:14.837Z","updated_at":"2019-03-28T10:35:44.177Z","position":5,"description":"Email and webhook delivery for GitHub notifications","showcase":false,"group_id":null,"page_id":"kctbh9vrtdwd","group":false,"only_show_if_degraded":false},{"id":"04c28ykz2c5m","name":"Gists","status":"operational","created_at":"2018-01-10T23:47:34.474Z","updated_at":"2019-01-15T23:11:22.612Z","position":6,"description":"Web service requests for gists","showcase":false,"group_id":null,"page_id":"kctbh9vrtdwd","group":false,"only_show_if_degraded":false},{"id":"vg70hn9s2tyj","name":"GitHub Pages","status":"operational","created_at":"2017-01-31T20:04:33.923Z","updated_at":"2019-04-13T17:58:34.132Z","position":7,"description":"Frontend application and API servers for Pages builds","showcase":false,"group_id":null,"page_id":"kctbh9vrtdwd","group":false,"only_show_if_degraded":false}],"incidents":[],"scheduled_maintenances":[],"status":{"indicator":"none","description":"All Systems Operational"}}';

        $this->assertFalse($service->testCheckResponse($content));
    }

    public function testCheckResponsePartialOutage() {
        $service = new GitHubStatusServiceExtend();

        $content = '{"page":{"id":"kctbh9vrtdwd","name":"GitHub","url":"https://www.githubstatus.com","time_zone":"Etc/UTC","updated_at":"2019-04-17T18:34:22.610Z"},"components":[{"id":"8l4ygp009s5s","name":"Git Operations","status":"operational","created_at":"2017-01-31T20:05:05.370Z","updated_at":"2019-04-01T13:31:10.941Z","position":1,"description":"Performance of git clones, pulls, pushes, and associated operations","showcase":false,"group_id":null,"page_id":"kctbh9vrtdwd","group":false,"only_show_if_degraded":false},{"id":"brv1bkgrwx7q","name":"API Requests","status":"partial_outage","created_at":"2017-01-31T20:01:46.621Z","updated_at":"2019-03-12T16:25:03.772Z","position":2,"description":"Requests for GitHub APIs","showcase":false,"group_id":null,"page_id":"kctbh9vrtdwd","group":false,"only_show_if_degraded":false},{"id":"kr09ddfgbfsf","name":"Issues, PRs, Dashboard, Projects","status":"operational","created_at":"2017-01-31T20:01:46.638Z","updated_at":"2019-04-11T17:05:46.862Z","position":3,"description":"Web requests for github.com UI and services","showcase":false,"group_id":null,"page_id":"kctbh9vrtdwd","group":false,"only_show_if_degraded":false},{"id":"0l2p9nhqnxpd","name":"Visit www.githubstatus.com for more information","status":"operational","created_at":"2018-12-05T19:39:40.838Z","updated_at":"2019-01-15T23:11:22.604Z","position":4,"description":null,"showcase":false,"group_id":null,"page_id":"kctbh9vrtdwd","group":false,"only_show_if_degraded":false},{"id":"5bfcr2x9x8kc","name":"Notifications","status":"operational","created_at":"2018-01-26T20:01:14.837Z","updated_at":"2019-03-28T10:35:44.177Z","position":5,"description":"Email and webhook delivery for GitHub notifications","showcase":false,"group_id":null,"page_id":"kctbh9vrtdwd","group":false,"only_show_if_degraded":false},{"id":"04c28ykz2c5m","name":"Gists","status":"operational","created_at":"2018-01-10T23:47:34.474Z","updated_at":"2019-01-15T23:11:22.612Z","position":6,"description":"Web service requests for gists","showcase":false,"group_id":null,"page_id":"kctbh9vrtdwd","group":false,"only_show_if_degraded":false},{"id":"vg70hn9s2tyj","name":"GitHub Pages","status":"operational","created_at":"2017-01-31T20:04:33.923Z","updated_at":"2019-04-13T17:58:34.132Z","position":7,"description":"Frontend application and API servers for Pages builds","showcase":false,"group_id":null,"page_id":"kctbh9vrtdwd","group":false,"only_show_if_degraded":false}],"incidents":[],"scheduled_maintenances":[],"status":{"indicator":"none","description":"All Systems Operational"}}';

        $this->assertFalse($service->testCheckResponse($content));
    }

    public function testCheckResponseMajorOutage() {
        $service = new GitHubStatusServiceExtend();

        $content = '{"page":{"id":"kctbh9vrtdwd","name":"GitHub","url":"https://www.githubstatus.com","time_zone":"Etc/UTC","updated_at":"2019-04-17T18:34:22.610Z"},"components":[{"id":"8l4ygp009s5s","name":"Git Operations","status":"operational","created_at":"2017-01-31T20:05:05.370Z","updated_at":"2019-04-01T13:31:10.941Z","position":1,"description":"Performance of git clones, pulls, pushes, and associated operations","showcase":false,"group_id":null,"page_id":"kctbh9vrtdwd","group":false,"only_show_if_degraded":false},{"id":"brv1bkgrwx7q","name":"API Requests","status":"major_outage","created_at":"2017-01-31T20:01:46.621Z","updated_at":"2019-03-12T16:25:03.772Z","position":2,"description":"Requests for GitHub APIs","showcase":false,"group_id":null,"page_id":"kctbh9vrtdwd","group":false,"only_show_if_degraded":false},{"id":"kr09ddfgbfsf","name":"Issues, PRs, Dashboard, Projects","status":"operational","created_at":"2017-01-31T20:01:46.638Z","updated_at":"2019-04-11T17:05:46.862Z","position":3,"description":"Web requests for github.com UI and services","showcase":false,"group_id":null,"page_id":"kctbh9vrtdwd","group":false,"only_show_if_degraded":false},{"id":"0l2p9nhqnxpd","name":"Visit www.githubstatus.com for more information","status":"operational","created_at":"2018-12-05T19:39:40.838Z","updated_at":"2019-01-15T23:11:22.604Z","position":4,"description":null,"showcase":false,"group_id":null,"page_id":"kctbh9vrtdwd","group":false,"only_show_if_degraded":false},{"id":"5bfcr2x9x8kc","name":"Notifications","status":"operational","created_at":"2018-01-26T20:01:14.837Z","updated_at":"2019-03-28T10:35:44.177Z","position":5,"description":"Email and webhook delivery for GitHub notifications","showcase":false,"group_id":null,"page_id":"kctbh9vrtdwd","group":false,"only_show_if_degraded":false},{"id":"04c28ykz2c5m","name":"Gists","status":"operational","created_at":"2018-01-10T23:47:34.474Z","updated_at":"2019-01-15T23:11:22.612Z","position":6,"description":"Web service requests for gists","showcase":false,"group_id":null,"page_id":"kctbh9vrtdwd","group":false,"only_show_if_degraded":false},{"id":"vg70hn9s2tyj","name":"GitHub Pages","status":"operational","created_at":"2017-01-31T20:04:33.923Z","updated_at":"2019-04-13T17:58:34.132Z","position":7,"description":"Frontend application and API servers for Pages builds","showcase":false,"group_id":null,"page_id":"kctbh9vrtdwd","group":false,"only_show_if_degraded":false}],"incidents":[],"scheduled_maintenances":[],"status":{"indicator":"none","description":"All Systems Operational"}}';

        $this->assertFalse($service->testCheckResponse($content));
    }

    public function testCheckResponseNoComponent() {
        $service = new GitHubStatusServiceExtend();

        $content = '{"page":{"id":"kctbh9vrtdwd","name":"GitHub","url":"https://www.githubstatus.com","time_zone":"Etc/UTC","updated_at":"2019-04-17T18:34:22.610Z"},"componentss":[{"id":"8l4ygp009s5s","name":"Git Operations","status":"operational","created_at":"2017-01-31T20:05:05.370Z","updated_at":"2019-04-01T13:31:10.941Z","position":1,"description":"Performance of git clones, pulls, pushes, and associated operations","showcase":false,"group_id":null,"page_id":"kctbh9vrtdwd","group":false,"only_show_if_degraded":false},{"id":"brv1bkgrwx7q","name":"API Requests","status":"major_outage","created_at":"2017-01-31T20:01:46.621Z","updated_at":"2019-03-12T16:25:03.772Z","position":2,"description":"Requests for GitHub APIs","showcase":false,"group_id":null,"page_id":"kctbh9vrtdwd","group":false,"only_show_if_degraded":false},{"id":"kr09ddfgbfsf","name":"Issues, PRs, Dashboard, Projects","status":"operational","created_at":"2017-01-31T20:01:46.638Z","updated_at":"2019-04-11T17:05:46.862Z","position":3,"description":"Web requests for github.com UI and services","showcase":false,"group_id":null,"page_id":"kctbh9vrtdwd","group":false,"only_show_if_degraded":false},{"id":"0l2p9nhqnxpd","name":"Visit www.githubstatus.com for more information","status":"operational","created_at":"2018-12-05T19:39:40.838Z","updated_at":"2019-01-15T23:11:22.604Z","position":4,"description":null,"showcase":false,"group_id":null,"page_id":"kctbh9vrtdwd","group":false,"only_show_if_degraded":false},{"id":"5bfcr2x9x8kc","name":"Notifications","status":"operational","created_at":"2018-01-26T20:01:14.837Z","updated_at":"2019-03-28T10:35:44.177Z","position":5,"description":"Email and webhook delivery for GitHub notifications","showcase":false,"group_id":null,"page_id":"kctbh9vrtdwd","group":false,"only_show_if_degraded":false},{"id":"04c28ykz2c5m","name":"Gists","status":"operational","created_at":"2018-01-10T23:47:34.474Z","updated_at":"2019-01-15T23:11:22.612Z","position":6,"description":"Web service requests for gists","showcase":false,"group_id":null,"page_id":"kctbh9vrtdwd","group":false,"only_show_if_degraded":false},{"id":"vg70hn9s2tyj","name":"GitHub Pages","status":"operational","created_at":"2017-01-31T20:04:33.923Z","updated_at":"2019-04-13T17:58:34.132Z","position":7,"description":"Frontend application and API servers for Pages builds","showcase":false,"group_id":null,"page_id":"kctbh9vrtdwd","group":false,"only_show_if_degraded":false}],"incidents":[],"scheduled_maintenances":[],"status":{"indicator":"none","description":"All Systems Operational"}}';

        $this->assertFalse($service->testCheckResponse($content));
    }
}
