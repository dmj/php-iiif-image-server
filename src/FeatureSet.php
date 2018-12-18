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

use ArrayObject;

/**
 * Feature set.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright (c) 2018 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3 or higher
 */
abstract class FeatureSet
{
    abstract public function getComplianceLevelUri ();
    abstract public function getRegionFeatures ();
    abstract public function getSizeFeatures ();
    abstract public function getRotationFeatures ();
    abstract public function getQualityFeatures ();
    abstract public function getFormatFeatures ();

    public function getRegion ()
    {
        return new Region($this->getRegionFeatures());
    }

    public function getSize ()
    {
        return new Size($this->getSizeFeatures());
    }

    public function getRotation ()
    {
        return new Rotation($this->getRotationFeatures());
    }

    public function getQuality ()
    {
        return new Quality($this->getQualityFeatures());
    }

    public function getFormat ()
    {
        return new Format($this->getFormatFeatures());
    }
}
