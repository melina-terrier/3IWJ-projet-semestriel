<?php

namespace App\Core;

use App\Models\User;
use App\Models\Page;
use App\Models\Project;
use App\Models\Status;

class Sitemap{

	public function renderSiteMap(){
        $statusModel = new Status();
        $status = $statusModel->getOneBy(["status" => "Publié"], 'object');
        $publishedStatusId = $status->getId();

        $page = new Page();
        $pages = $page->getAllDataWithWhere(['status_id'=>$publishedStatusId], 'object');
        $project = new Project();
        $projects = $project->getAllDataWithWhere(['status_id'=>$publishedStatusId], 'object');
        
        $xml = new \DOMDocument('1.0', 'UTF-8');
        $urlset = $xml->createElement('urlset');
        $xml->appendChild($urlset);

        foreach($pages as $page)
        {
            $url = $xml->createElement('url');
            $urlset->appendChild($url);

            $loc = $xml->createElement('loc');
            $locText = "https://locallhost/";
            $locText .= $page->getSlug();
            $loc->appendChild($xml->createTextNode($locText));
            $url->appendChild($loc);

            $lastmod = $xml->createElement('lastmod');
            $lastmodText = $page->getModificationDate();
            $lastmod->appendChild($xml->createTextNode($lastmodText));
            $url->appendChild($lastmod);

            $changefreq = $xml->createElement('changefreq');
            $changefreqText = 'daily'; // Adjust frequency as needed
            $changefreq->appendChild($xml->createTextNode($changefreqText));
            $url->appendChild($changefreq);

            $priority = $xml->createElement('priority');
            $priorityText = '1.0'; // Adjust priority based on page importance
            $priority->appendChild($xml->createTextNode($priorityText));
            $url->appendChild($priority);
        }

        foreach($projects as $project)
        {
            $url = $xml->createElement('url');
            $urlset->appendChild($url);

            $loc = $xml->createElement('loc');
            $locText = "https://locallhost.com/projects/";
            $locText .= $project->getSlug();
            $loc->appendChild($xml->createTextNode($locText));
            $url->appendChild($loc);

            $lastmod = $xml->createElement('lastmod');
            $lastmodText = $project->getModificationDate();
            $lastmod->appendChild($xml->createTextNode($lastmodText));
            $url->appendChild($lastmod);

            $changefreq = $xml->createElement('changefreq');
            $changefreqText = 'daily';
            $changefreq->appendChild($xml->createTextNode($changefreqText));
            $url->appendChild($changefreq);

            $priority = $xml->createElement('priority');
            $priorityText = '1.0'; 
            $priority->appendChild($xml->createTextNode($priorityText));
            $url->appendChild($priority);
        }

        $xml->formatOutput = true;
        $xmlContent = $xml->saveXML();

        $filename = 'sitemap.xml';
        file_put_contents($filename, $xmlContent);
	}
}