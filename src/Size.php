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
 * Size feautes.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright (c) 2018 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3 or higher
 */
class Size extends Feature
{
    const sizeByW           = 0b00000001;
    const sizeByH           = 0b00000010;
    const sizeByPct         = 0b00000100;
    const sizeByConfinedWh  = 0b00001000;
    const sizeByDistortedWh = 0b00010000;
    const sizeAboveFull     = 0b00100000;

    const featureNames = array(
        Size::sizeByW           => 'sizeByW',
        Size::sizeByH           => 'sizeByH',
        Size::sizeByPct         => 'sizeByPct',
        Size::sizeByConfinedWh  => 'sizeByConfinedWh',
        Size::sizeByDistortedWh => 'sizeByDistortedWh',
        Size::sizeAboveFull     => 'sizeAboveFull'
    );

    public function __construct ($features = 0)
    {
        $this->features = $features;
    }

    public function createTransform ($spec)
    {
        if ($spec == 'full') {
            return null;
        }

        $that = $this;
        if ($this->features & Size::sizeByW) {
            if (preg_match('@^(?<w>[0-9]+),$@u', $spec, $match)) {
                $width = $match['w'];
                return function ($image) use ($that, $width) {
                    $height = round(imagesy($image) * ($width / imagesx($image)));
                    return $that->scale($image, $width, $height);
                };
            }
        }
        if ($this->features & Size::sizeByH) {
            if (preg_match('@^,(?<h>[0-9]+)$@u', $spec, $match)) {
                $height = $match['h'];
                return function ($image) use ($that, $height) {
                    $width = round(imagesx($image) * ($height / imagesy($image)));
                    return $that->scale($image, $width, $height);
                };
            }
        }
        if ($this->features & Size::sizeByPct) {
            if (preg_match('@^pct:(?<pct>[0-9]+(\.[0-9]+)?)$@u', $spec, $match)) {
                $pct = floatval($match['pct']);
                return function ($image) use ($that, $pct) {
                    $width = round(imagesx($image) * $pct / 100);
                    $height = round(imagesy($image) * $pct / 100);
                    return $that->scale($image, $width, $height);
                };
            }
        }
        if ($this->features & Size::sizeByConfinedWh) {
            if (preg_match('@^!(?<w>[0-9]+),(?<h>[0-9]+)$@u', $spec, $match)) {
                $width = $match['w'];
                $height = $match['h'];
                return function ($image) use ($that, $width, $height) {
                    $wScale = $width / imagesx($image);
                    $hScale = $height / imagesy($image);
                    $scale = min($wScale, $hScale);
                    $width = imagesx($image) * $scale;
                    $height = imagesy($image) * $scale;
                    return $that->scale($image, $width, $height);
                };
            }
        }
        if ($this->features & Size::sizeByDistortedWh) {
            if (preg_match('@^(?<w>[0-9]+),(?<h>[0-9]+)$@u', $spec, $match)) {
                $width = $match['w'];
                $height = $match['h'];
                return function ($image) use ($that, $width, $height) {
                    return $that->scale($image, $width, $height);
                };
            }
        }
        throw new UnsupportedFeature(sprintf('Unsupported image size feature request: %s', $spec));
    }

    public function scale ($image, $width, $height)
    {
        if (!($this->features & Size::sizeAboveFull)) {
            if ($width > imagesx($image) || $height > imagesy($image)) {
                throw new UnsupportedFeature('Cannot scale image above full');
            }
        }
        return imagescale($image, $width, $height);
    }
}
