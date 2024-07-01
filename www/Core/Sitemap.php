<?php
namespace App\Core;
use App\Models\entry;
use App\Models\Project;
use App\Models\Status;

class Sitemap{

    public function generateSiteMap(): void
    {
        $statusModel = new Status();
        $status = $statusModel->getByName("Publié");
        $page = new Page();
        $pages = $page->getAllData(['status_id'=>$status], null, 'object');
        $project = new Project();
        $projects = $project->getAllData(['status_id'=>$status], null, 'object');
        $this->generateSiteMapForModels([$pages, $projects], $status);
    }

    private function generateSiteMapForModels(array $models, int $publishedStatusId): void 
    {
        $xml = new \DOMDocument('1.0', 'UTF-8');
        $urlset = $xml->createElement('urlset');
        $xml->appendChild($urlset);
        foreach($entris as $entry)
        {
            $url = $xml->createElement('url');
            $urlset->appendChild($url);
            $loc = $xml->createElement('loc');
            $locText = "https://locallhost/";
            $locText .= $entry->getSlug();
            $loc->appendChild($xml->createTextNode($locText));
            $url->appendChild($loc);
            $lastmod = $xml->createElement('lastmod');
            $lastmodText = $entry->getModificationDate();
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
        file_put_contents('sitemap.xml', $xmlContent);
	}
    
}