<?php

namespace App\Entity;


class PropertySearch
{
    /**
     * @var string|null
     */
 private $platform;

    /**
     * @var string|null
     */
 private $genres;

    /**
     * @return string|null
     */
    public function getPlatform(): ?string
    {
        return $this->platform;
    }

    /**
     * @param string|null $platform
     * @return PropertySearch
     */
    public function setPlatform(?string $platform): PropertySearch
    {
        $this->platform = $platform;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getGenres(): ?string
    {
        return $this->genres;
    }

    /**
     * @param string|null $genres
     * @return PropertySearch
     */
    public function setGenres(?string $genres): PropertySearch
    {
        $this->genres = $genres;
        return $this;
    }

}