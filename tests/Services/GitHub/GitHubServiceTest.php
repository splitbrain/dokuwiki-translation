<?php

namespace App\Tests\Services\GitHub;

use App\Services\GitHub\GitHubService;
use App\Services\GitHub\GitHubServiceException;
use PHPUnit\Framework\TestCase;

class GitHubServiceTest extends TestCase {

    function testGetUsernameAndRepositoryFromURLWithHTTP() {
        $api = new GitHubService('', '', '', false);

        $result = $api->getUsernameAndRepositoryFromURL('https://github.com/dokuwiki/dokuwiki.git');
        $this->assertEquals(['dokuwiki', 'dokuwiki'], $result);
        $result = $api->getUsernameAndRepositoryFromURL('https://github.com/dom-mel/dokuwiki.git');
        $this->assertEquals(['dom-mel', 'dokuwiki'], $result);
    }

    public function dataProvider_getUsernameAndRepositoryFromURL() {
        return [
            ['git@github.com:dokuwiki/dokuwiki.git',      ['dokuwiki', 'dokuwiki']],
            ['git@github.com:dom-mel/dokuwiki.git',         ['dom-mel', 'dokuwiki']],
            ['git@sub.github.com:dokuwiki/dokuwiki.git',  ['dokuwiki', 'dokuwiki']],
            ['git@sub.github.com:dom-mel/dokuwiki.git',     ['dom-mel', 'dokuwiki']],
            ['git://github.com/dokuwiki/dokuwiki.git',    ['dokuwiki', 'dokuwiki']],
            ['git://github.com/dom-mel/dokuwiki.git',       ['dom-mel', 'dokuwiki']],
        ];
    }

    /**
     * @dataProvider dataProvider_getUsernameAndRepositoryFromURL
     *
     * @param $url
     * @param $expected
     *
     * @throws GitHubServiceException
     */
    function testGetUsernameAndRepositoryFromURLWithGit($url, $expected) {
        $api = new GitHubService('', '', '', false);

        $result = $api->getUsernameAndRepositoryFromURL($url);
        $this->assertEquals($expected, $result);

        $result = $api->getUsernameAndRepositoryFromURL('git@github.com:splitbrain/dokuwiki.git');
        $this->assertEquals(array('splitbrain', 'dokuwiki'), $result);

        $result = $api->getUsernameAndRepositoryFromURL('git@github.com:dom-mel/dokuwiki.git');
        $this->assertEquals(array('dom-mel', 'dokuwiki'), $result);

        $result = $api->getUsernameAndRepositoryFromURL('git@sub.github.com:splitbrain/dokuwiki.git');
        $this->assertEquals(array('splitbrain', 'dokuwiki'), $result);

        $result = $api->getUsernameAndRepositoryFromURL('git@sub.github.com:dom-mel/dokuwiki.git');
        $this->assertEquals(array('dom-mel', 'dokuwiki'), $result);

        $result = $api->getUsernameAndRepositoryFromURL('git://github.com/splitbrain/dokuwiki.git');
        $this->assertEquals(array('splitbrain', 'dokuwiki'), $result);

        $result = $api->getUsernameAndRepositoryFromURL('git://github.com/dom-mel/dokuwiki.git');
        $this->assertEquals(array('dom-mel', 'dokuwiki'), $result);
    }

    function testGetUsernameAndRepositoryFromURLWithError() {
        $api = new GitHubService('', '', '', false);

        $this->expectException(GitHubServiceException::class);
        $api->getUsernameAndRepositoryFromURL('Wrong:dokuwiki/dokuwiki.git');
    }

    function testGetUsernameAndRepositoryFromURLWithErrorNoGitExtension() {
        $api = new GitHubService('', '', '', false);

        $this->expectException(GitHubServiceException::class);
        $api->getUsernameAndRepositoryFromURL('https://github.com/Klap-in/dokuwiki-plugin-docnavigation');
    }

    function testGitHubUrlHack() {
        $api = new GitHubService('', '', 'github.com', false);
        $this->assertEquals('github.com something', $api->gitHubUrlHack('github.com something'));

        $api = new GitHubService('', '', 'some.github.com', false);
        $this->assertEquals('git@some.github.com', $api->gitHubUrlHack('git@github.com'));
    }

}