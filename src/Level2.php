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
 * Feature set of IIIF Image API Compliance Level 2.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright (c) 2018 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3 or higher
 */
class Level2 extends FeatureSet
{
    public function getComplianceLevelUri ()
    {
        return 'http://iiif.io/api/image/2/level2.json';
    }

    public function getRegionFeatures ()
    {
        return Region::regionByPx | Region::regionByPct;
    }

    public function getSizeFeatures ()
    {
        return Size::sizeByW | Size::sizeByH | Size::sizeByPct | Size::sizeByConfinedWh | Size::sizeByDistortedWh;
    }

    public function getRotationFeatures ()
    {
        return Rotation::mirroring | Rotation::rotationBy90s;
    }

    public function getQualityFeatures ()
    {
        return Quality::default | Quality::gray | Quality::bitonal;
    }

    public function getFormatFeatures ()
    {
        return Format::jpg | Format::png;
    }
}
