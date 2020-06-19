<?php

namespace Silverstripe\GithubIssueSearch\Util;

/**
 * Could've done this with composer/composer package,
 * but seemed a bit overkill :D
 */
class UrlGenerator
{
    /**
     * @var string
     */
    protected $urlTemplate = 'https://silverstripe-github-issues.now.sh?customRepos=%s';

    /**
     * @param string $lockfileStr
     * @return string|null URL
     */
    public function generate(string $lockfileStr)
    {
        $data = json_decode($lockfileStr, true);

        $urls = array_filter(array_map(function ($package) {
            if (!$this->isSilverstripeRepo($package) || !$this->isGithubRepo($package)) {
                return null;
            }

            return $package['source']['url'];
        }, $data['packages']));

        if (!$urls) {
            return null;
        }

        // Assuming Github URLs, the "identifier" is the same as the path name
        $ids = array_filter(array_map(function($url) {
            return $this->extractRepoIdentifier($url);
        }, $urls));

        return sprintf($this->urlTemplate, implode(',', $ids));
    }

    protected function isSilverstripeRepo($package)
    {
        $types = [
            'silverstripe-module',
            'silverstripe-vendormodule',
            'silverstripe-recipe'
        ];
        return in_array($package['type'], $types);
    }

    protected function isGithubRepo($package)
    {
        if (!isset($package['source']['url'])) {
            return false;
        }

        $url = $package['source']['url'];

        return (
            preg_match('#^https?://github.com#', $url) ||
            preg_match('#^https?://www.github.com#', $url)
        );
    }

    protected function extractRepoIdentifier($url)
    {
        return trim(preg_replace('/\.git$/', '', parse_url($url, PHP_URL_PATH)), '/');
    }
}