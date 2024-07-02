<?php
namespace App\Models;
use App\Core\SQL;
use App\Models\Project_Tags;

class Project extends SQL
{
    protected ?int $id = null;
    protected string $title;
    protected string $content;
    protected string $slug;
    protected int $status_id;
    protected string $creation_date;
    protected string $modification_date;
    protected string $publication_date;
    protected int $user_id;
    protected ?string $featured_image = null;
    protected string $seo_title;
    protected string $seo_keyword;
    protected string $seo_description;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $title = strip_tags(trim($title));
        $this->title = $title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $allowedTags = '<p><strong><em><u><h1><h2><h3><h4><h5><h6><img>';
        $allowedTags .= '<li><ol><ul><span><div><br><ins><del><table><tr><td><th><tbody><thead><tfoot>';
        $allowedTags .= '<a><hr><iframe><video><source><embed><object><param>';
        $content = strip_tags(stripslashes($content), $allowedTags);
        $this->content = $content;
    }

    public function getStatus(): int
    {
        return $this->status_id;
    }

    public function setStatus(int $status_id): void
    {
        $this->status_id = $status_id;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
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

    public function getCreationDate(): string
    {
        return $this->creation_date;
    }

    public function setCreationDate(string $creation_date): void
    {
        $this->creation_date = $creation_date;
    }

    public function getModificationDate(): string
    {
        return $this->modification_date;
    }

    public function setModificationDate(string $modification_date): void
    {
        $this->modification_date = $modification_date;
    }

    public function getPublicationDate(): string
    {
        return $this->publication_date;
    }

    public function setPublicationDate(string $publication_date): void
    {
        $this->publication_date = $publication_date;
    }

    public function getUser(): int
    {
        return $this->user_id;
    }

    public function setUser(int $user_id): void
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

    public function getSeoKeyword(): string
    {
        return $this->seo_keyword;
    }

    public function setSeoKeyword(string $seo_keyword): void
    {
        $seo_keyword = trim(strtolower($seo_keyword));
        $this->seo_keyword = $seo_keyword;
    }

    public function getSeoTitle(): string
    {
        return $this->seo_title;
    }

    public function setSeoTitle(string $seo_title): void
    {
        $seo_title = ucwords(trim(strtolower($seo_title)));
        $this->seo_title = $seo_title;
    }

    public function getSeoDescription(): string
    {
        return $this->seo_description;
    }

    public function setSeoDescription(string $seo_description): void
    {
        $seo_description = trim($seo_description);
        $this->seo_description = $seo_description;
    }


    public function getNbElements() {
        return $this->countElements();
    }

    public function getSeoAnalysis() {
        $analysis = [
            'external_links' => false,
            'images' => false,
            'internal_links' => false,
            'keyword_presence' => false,
            'meta_description_length' => false,
            'content_length' => false,
            'seo_title_length' => false
        ];

        if (preg_match('/<a\s+(?:[^>]*?\s+)?href="http/', $this->content)) {
            $analysis['external_links'] = true;
        }

        if (preg_match('/<img\s+(?:[^>]*?\s+)?src=/', $this->content)) {
            $analysis['images'] = true;
        }

        if (preg_match('/<a\s+(?:[^>]*?\s+)?href="[^"]*\.\.\//', $this->content)) {
            $analysis['internal_links'] = true;
        }

        if ($this->seo_keyword) {
            $keywords = explode(',', $this->seo_keyword);
            foreach ($keywords as $keyword) {
                if (stripos($this->content, trim($keyword)) !== false) {
                    $analysis['keyword_presence'] = true;
                    break;
                }
            }
        }

        if (isset($this->seo_description) && 50 <= strlen($this->seo_description) && strlen($this->seo_description) <= 160) {
            $analysis['meta_description_length'] = true;
        }

        if (str_word_count($this->content) >= 300) {
            $analysis['content_length'] = true;
        }

        if ($this->seo_title) {
            $titleLength = strlen($this->seo_title);
            if ($titleLength >= 50 && $titleLength <= 60) {
                $analysis['seo_title_length'] = true;
            }
        }

        return $analysis;
    }

    public function getSeoStatus() {
        $analysis = $this->getSeoAnalysis();
        $score = 0;

        foreach ($analysis as $result) {
            if ($result) {
                $score++;
            }
        }

        if ($score >= 5) {
            return 'ok';
        } elseif ($score >= 2) {
            return 'pas mal';
        } else {
            return 'mauvais';
        }
    }
}