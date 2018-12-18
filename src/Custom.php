<?php

/**
 * This file is part of PHP IIIF Image Server.
 *
 * PHP IIIF Image Server is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * PHP IIIF Image Server is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with PHP IIIF Image Server.  If not, see <https://www.gnu.org/licenses/>.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright (c) 2018 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3 or higher
 */

namespace HAB\Diglib\API\IIIF\ImageServer;

/**
 * Custom feature set.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright (c) 2018 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3 or higher
 */
class Custom extends FeatureSet
{
    private $complianceLevelUri;
    private $regionFeatures = 0;
    private $sizeFeatures = 0;
    private $rotationFeatures = 0;
    private $qualityFeatures = 0;
    private $formatFeatures = 0;

    public function __construct (FeatureSet $base = null)
    {
        if ($base) {
            $this->complianceLevelUri = $base->getComplianceLevelUri();
            $this->regionFeatures = $base->getRegionFeatures();
            $this->sizeFeatures = $base->getSizeFeatures();
            $this->rotationFeatures = $base->getRotationFeatures();
            $this->qualityFeatures = $base->getQualityFeatures();
            $this->formatFeatures = $base->getFormatFeatures();
        }
    }

    public function getComplianceLevelUri ()
    {
        return $this->complianceLevelUri;
    }

    public function getRegionFeatures ()
    {
        return $this->regionFeatures;
    }

    public function getSizeFeatures ()
    {
        return $this->sizeFeatures;
    }

    public function getRotationFeatures ()
    {
        return $this->rotationFeatures;
    }

    public function getQualityFeatures ()
    {
        return $this->qualityFeatures;
    }

    public function getFormatFeatures ()
    {
        return $this->formatFeatures;
    }

    public function addRotationFeatures ($features)
    {
        $this->rotationFeatures |= $features;
    }

    public function addQualityFeatures ($features)
    {
        $this->qualityFeatures |= $features;
    }

    public function addFormatFeatures ($features)
    {
        $this->formatFeatures |= $features;
    }

    public function addSizeFeatures ($features)
    {
        $this->sizeFeatures |= $features;
    }

    public function addRegionFeatures ($features)
    {
        $this->regionFeatures |= $features;
    }
}
