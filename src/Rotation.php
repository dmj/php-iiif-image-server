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
 * Rotation features.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright (c) 2018 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3 or higher
 */
class Rotation extends Feature
{
    const rotationBy90s     = 0b00000001;
    const rotationArbitrary = 0b00000010;
    const mirroring         = 0b00000100;

    const featureNames = array(
        Rotation::rotationBy90s     => 'rotationBy90s',
        Rotation::rotationArbitrary => 'rotationArbitrary',
        Rotation::mirroring         => 'mirroring'
    );

    public function __construct ($features = 0)
    {
        $this->features = $features;
    }

    public function createTransform ($spec)
    {
        if (preg_match('@(?<mirror>!)?(?<angle>[0-9]+(\.[0-9]+)?)@u', $spec, $match)) {
            $mirror = null;
            if ($match['mirror']) {
                if ($this->features & Rotation::mirroring) {
                    $mirror = function ($image) {
                        if (imageflip($image, IMG_FLIP_HORIZONTAL)) {
                            return $image;
                        }
                    };
                } else {
                    throw new UnsupportedFeature('Mirroring feature not supported');
                }
            }

            $angle = $match['angle'];
            if ($angle == '0') {
                return $mirror;
            }
            if ($this->features & Rotation::rotationBy90s) {
                if ($angle == '90' || $angle == '180' || $angle == '270') {
                    $angle = (360 - floatval($angle)) % 360;
                    return function ($image) use ($angle, $mirror) {
                        if ($mirror) {
                            call_user_func($mirror, $image);
                        }
                        if (is_resource($image)) {
                            return imagerotate($image, $angle, 0);
                        }
                    };
                }
            }
            if ($this->features & Rotation::rotationArbitrary) {
                $angle = (360 - floatval($angle)) % 360;
                return function ($image) use ($angle, $mirror) {
                    if ($mirror) {
                        call_user_func($mirror, $image);
                    }
                    if (is_resource($image)) {
                        return imagerotate($image, $angle, 0);
                    }
                };
            }
        }
        throw new UnsupportedFeature(sprintf('Unsupported image rotation request: %s', $spec));
    }
}
