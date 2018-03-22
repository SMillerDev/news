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

namespace OCA\News\Fetcher;

interface IFeedFetcher
{

    /**
     * @param string                                                        $url               remote url of the feed
     * @param boolean                                                       $getFavicon        if the favicon should also be fetched,
     *                                                                                         defaults to true
     * @param string                                                        $lastModified      a last modified value from an http header
     *                                                                                         defaults to false. If lastModified
     *                                                                                         matches the http header from the feed no
     *                                                                                         results are fetched
     * @param string                                                        $etag              an etag from an http header.
     *                                                                                         If lastModified matches the
     *                                                                                         http header from the feed no
     *                                                                                         results are fetched
     * @param bool fullTextEnabled if true tells the fetcher to enhance the
     * articles by fetching custom enhanced content
     * @param string                                                        $basicAuthUser     if given, basic auth is set for this feed
     * @param string                                                        $basicAuthPassword if given, basic auth is set for this
     *                                                                                         feed. Ignored if user is null or an
     *                                                                                         empty string
     * @throws FetcherException if the fetcher encounters a problem
     * @return array an array containing the new feed and its items, first
     * element being the Feed and second element being an array of Items
     */
    function fetch($url, $getFavicon=true, $lastModified=null, $etag=null,
        $fullTextEnabled=false, $basicAuthUser=null,
        $basicAuthPassword=null
    );

    /**
     * @param string $url the url that should be fetched
     * @return boolean if the fetcher can handle the url. This fetcher will be
     * used exclusively to fetch the feed and the items of the page
     */
    function canHandle($url);

}
