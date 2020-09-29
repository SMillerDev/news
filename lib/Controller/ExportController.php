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

namespace OCA\News\Controller;

use OCA\News\Service\FeedServiceV2;
use OCA\News\Service\FolderServiceV2;
use OCA\News\Service\ItemServiceV2;
use OCA\News\Service\OpmlService;
use OCP\AppFramework\Http\DataDownloadResponse;
use \OCP\IRequest;
use \OCP\AppFramework\Controller;
use \OCP\AppFramework\Http\JSONResponse;

class ExportController extends Controller
{

    private $opmlService;
    private $folderService;
    private $feedService;
    private $itemService;
    private $userId;

    public function __construct(
        string $appName,
        IRequest $request,
        FolderServiceV2 $folderService,
        FeedServiceV2 $feedService,
        ItemServiceV2 $itemService,
        OpmlService $opmlService,
        string $UserId
    ) {
        parent::__construct($appName, $request);
        $this->feedService = $feedService;
        $this->folderService = $folderService;
        $this->opmlService = $opmlService;
        $this->itemService = $itemService;
        $this->userId = $UserId;
    }


    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function opml(): DataDownloadResponse
    {
        $date = date('Y-m-d');

        return new DataDownloadResponse(
            $this->opmlService->export($this->userId),
            "subscriptions-${date}.opml",
            'text/xml'
        );
    }


    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function articles(): JSONResponse
    {
        $feeds = $this->feedService->findAllForUser($this->userId);
        $items = $this->itemService->findAllForUser($this->userId, ['unread' => true, 'starred' => true]);

        // build assoc array for fast access
        $feedsDict = [];
        foreach ($feeds as $feed) {
            $feedsDict['feed' . $feed->getId()] = $feed;
        }

        $articles = [];
        foreach ($items as $item) {
            $articles[] = $item->toExport($feedsDict);
        }

        $response = new JSONResponse($articles);
        $response->addHeader(
            'Content-Disposition',
            'attachment; filename="articles.json"'
        );
        return $response;
    }
}
