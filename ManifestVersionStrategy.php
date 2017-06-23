<?php

/*
 * This file is part of Mindy Framework.
 * (c) 2017 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\ManifestVersionStrategy;

use Symfony\Component\Asset\VersionStrategy\VersionStrategyInterface;

class ManifestVersionStrategy implements VersionStrategyInterface
{
    /**
     * @var string
     */
    private $manifestPath;
    /**
     * @var string[]
     */
    private $hashes;
    /**
     * @var bool
     */
    private $debug = false;

    /**
     * @param string $manifestPath
     * @param bool $debug
     */
    public function __construct($manifestPath, $debug = false)
    {
        $this->manifestPath = $manifestPath;
        $this->debug = $debug;
    }

    public function getVersion($path)
    {
        if (!is_array($this->hashes)) {
            $this->hashes = $this->loadManifest();
        }

        return isset($this->hashes[$path]) ? $this->hashes[$path] : '';
    }

    public function applyVersion($path)
    {
        if ($this->debug) {
            return $path;
        }
        return $this->getVersion($path);
    }

    private function loadManifest()
    {
        return json_decode(file_get_contents($this->manifestPath), true);
    }
}
