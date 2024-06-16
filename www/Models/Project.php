<?php

namespace App\Models;

use App\Core\SQL;
use App\Models\Project_Tags;

class Project extends SQL
{
    protected ?int $id = null;
    protected $title;
    protected $content;
    protected $slug;
    protected $status_id;
    protected $creation_date;
    protected $modification_date;
    protected $publication_date;
    protected $user_id;
    protected $featured_image;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        if (is_null($id) || empty($id)) {
            $sql = new SQL();
            $sequenceName = 'msnu_project_id_seq';
            $generatedId = $sql->generateId($sequenceName);
            $this->id = $generatedId;
        } else {
            $this->id = $id;
        }
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content): void
    {
        $this->content = $content;
    }

    public function getStatus()
    {
        return $this->status_id;
    }

    public function setStatus($status_id): void
    {
        $this->status_id = $status_id;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug): void
    {
        $slug = strtolower($slug);
        $slug = trim($slug);
        $slug = str_replace(' ', '-', $slug);
        $search  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
        $replace = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');
        $slug = str_replace($search, $replace, $slug);
        $allowedChars = 'abcdefghijklmnopqrstuvwxyz09-';
        $slug = preg_replace('/[^' . $allowedChars . ']/', '', $slug);
        $this->slug = $slug;
    }

    public function getCreationDate()
    {
        return $this->creation_date;
    }

    public function setCreationDate($creation_date): void
    {
        $this->creation_date = $creation_date;
    }

    public function getModificationDate()
    {
        return $this->modification_date;
    }

    public function setModificationDate($modification_date): void
    {
        $this->modification_date = $modification_date;
    }

    public function getPublicationDate()
    {
        return $this->publication_date;
    }

    public function setPublicationDate($publication_date): void
    {
        $this->publication_date = $publication_date;
    }

    public function getUser()
    {
        return $this->user_id;
    }

    public function setUser($user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getFeaturedImage(): string
    {
        return $this->featured_image;
    }

    public function setFeaturedImage(?string $featured_image): void
    {
        $this->featured_image = $featured_image;
    }

    public function getTag()
    {
        $projectId = $this->getId();
        $tags = [];
        $projectTag = new Project_Tags();
        $tagArray = $projectTag->getAllDataWithWhere(['project_id'=>$projectId]);
        foreach ($tagArray as $tag) {
            $tags[] = $tag['tag_id'];
        }
        return $tags;
    }

    public function setTag(array $tag_ids): void
    {
        $projectTag = new Project_Tags();
        $existingTags = $projectTag->getAllDataWithWhere(['project_id' => $this->getId()]);
        if ($existingTags) {
            foreach ($existingTags as $tag) {
                $projectTag->delete($tag);
            }
        }
        foreach ($tag_ids as $tag_id) {
            $projectTag = new Project_Tags();
            $projectTag->setProjectId($this->getId());
            $projectTag->setTagId($tag_id);
            $projectTag->save();
        }
    }


    public function getNbElements() {
        return $this->countElements();
    }

}
