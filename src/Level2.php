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
    protected static $complianceLevelUri = 'http://iiif.io/api/image/2/level2.json';

    protected static $region = Region::regionByPx | Region::regionByPct;
    protected static $size = Size::sizeByW | Size::sizeByH | Size::sizeByPct | Size::sizeByConfinedWh | Size::sizeByDistortedWh;
    protected static $rotation = Rotation::rotationBy90s;
    protected static $quality = Quality::default | Quality::color | Quality::gray | Quality::bitonal;
    protected static $format = Format::jpg | Format::png;
}
