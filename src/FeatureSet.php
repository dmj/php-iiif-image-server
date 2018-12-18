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
    public function getComplianceLevelUri ()
    {
        return static::$complianceLevelUri;
    }

    public function apply ($image, $region, $size, $rotation, $quality)
    {
        $chain = new ArrayObject();
        $this->push($chain, $this->getRegion()->createTransform($region));
        $this->push($chain, $this->getSize()->createTransform($size));
        $this->push($chain, $this->getRotation()->createTransform($rotation));
        $this->push($chain, $this->getQuality()->createTransform($quality));

        foreach ($chain as $function) {
            $image = call_user_func($function, $image);
            if (!is_resource($image)) {
                throw new RuntimeException("Error in image transformation");
            }
        }
        return $image;
    }

    public function serialize ($image, $buffer, $format)
    {
        $serializer = $this->getFormat()->createTransform($format);
        call_user_func($serializer, $image, $buffer);
        return $buffer;
    }

    public function getProfile ()
    {
        $profile = array(
            'formats' => $this->getFormat()->getSupportedFeatures(),
            'qualities' => $this->getQuality()->getSupportedFeatures(),
            'supports' => array_merge(
                $this->getRegion()->getSupportedFeatures(),
                $this->getSize()->getSupportedFeatures(),
                $this->getRotation()->getSupportedFeatures()
            ),
        );
        return $profile;
    }

    public function getRegion ()
    {
        return new Region(static::$region);
    }

    public function getSize ()
    {
        return new Size(static::$size);
    }

    public function getRotation ()
    {
        return new Rotation(static::$rotation);
    }

    public function getQuality ()
    {
        return new Quality(static::$quality);
    }

    public function getFormat ()
    {
        return new Format(static::$format);
    }

    private function push (ArrayObject $chain, $function)
    {
        if ($function) {
            $chain->append($function);
        }
    }
}
