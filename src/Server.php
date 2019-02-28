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
 * Abstract base class.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright (c) 2018 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3 or higher
 */
abstract class Server
{
    protected $features;

    public function __construct (FeatureSet $features)
    {
        $this->features = $features;
    }

    public function getComplianceLevel ()
    {
        return $this->features->getComplianceLevelUri();
    }

    public function getProfile ()
    {
        $profile = array(
            'formats' => $this->features->getFormat()->getSupportedFeatures(),
            'qualities' => $this->features->getQuality()->getSupportedFeatures(),
            'supports' => array_merge(
                $this->features->getRegion()->getSupportedFeatures(),
                $this->features->getSize()->getSupportedFeatures(),
                $this->features->getRotation()->getSupportedFeatures()
            ),
        );
        return $profile;
    }

}
