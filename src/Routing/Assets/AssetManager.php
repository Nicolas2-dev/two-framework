<?php
/**
 * @author  Nicolas Devoy
 * @email   nicolas@Two-framework.fr 
 * @version 1.0.0
 * @date    15 mai 2024
 */
namespace Two\Routing\Assets;

use InvalidArgumentException;

use Two\Support\Arr;
use Two\View\Factory as ViewFactory;


class AssetManager
{
    /**
     * L’instance de View Factory.
     *
     * @var \Two\View\Factory
     */
     protected $views;

    /**
     * Les types d'actifs
     *
     * @var array
     */
    protected $types = array('css', 'js');

    /**
     * Les positions d’actifs
     *
     * @var array
     */
    protected $positions = array(
        'css' => array(),
        'js'  => array(),
    );

    /**
     * Les modèles d'actifs 
     *
     * @var array
     */
    protected static $templates = array(
        'default' => array(
            'css' => '<link href="%s" rel="stylesheet" type="text/css">',
            'js'  => '<script src="%s" type="text/javascript"></script>',
        ),
        'inline' => array(
            'css' => '<style>%s</style>',
            'js'  => '<script type="text/javascript">%s</script>',
        ),
    );


    /**
     * Créez une nouvelle instance Assets Manager.
     *
     * @return void
     */
    public function __construct(ViewFactory $views)
    {
        $this->views = $views;
    }

    /**
     * Enregistrez de nouveaux actifs.
     *
     * @param  string|array $assets
     * @param  string $type
     * @param  string $position
     * @param  int $order
     * @param  string $mode
     *
     * @return void
     * @throws \InvalidArgumentException
     */
    public function register($assets, $type, $position, $order = 0, $mode = 'default')
    {
        if (! in_array($type, $this->types)) {
            throw new InvalidArgumentException("Invalid assets type [{$type}]");
        } else if (! in_array($mode, array('default', 'inline', 'view'))) {
            throw new InvalidArgumentException("Invalid assets mode [{$mode}]");
        }

        // Le type et le mode des actifs sont valides.
        else if (! empty($items = $this->parseAssets($assets, $order, $mode))) {
            // Nous fusionnerons les éléments pour le type et la position spécifiés.

            Arr::set($this->positions, $key = "{$type}.{$position}", array_merge(
                Arr::get($this->positions, $key, array()), $items
            ));
        }
    }

    /**
     * Restituer les actifs pour les positions spécifiées
     *
     * @param  string|array $position
     * @param  string $type
     *
     * @return string
     * @throws \InvalidArgumentException
     */
    public function position($position, $type)
    {
        if (! in_array($type, $this->types)) {
            throw new InvalidArgumentException("Invalid assets type [{$type}]");
        }

        $positions = is_array($position) ? $position : array($position);

        //
        $result = array();

        foreach ($positions as $position) {
            $items = Arr::get($this->positions, "{$type}.{$position}", array());

            if (! empty($items)) {
                $result = array_merge($result, $this->renderItems($items, $type, true));
            }
        }

        return implode("\n", array_unique($result));
    }

    /**
     * Rendu les scripts CSS ou JS.
     *
     * @param string       $type
     * @param string|array $assets
     *
     * @return string|null
     * @throws \InvalidArgumentException
     */
    public function render($type, $assets)
    {
        if (! in_array($type, $this->types)) {
            throw new InvalidArgumentException("Invalid assets type [{$type}]");
        }

        // Le type d'actif est valide.
        else if (! empty($items = $this->parseAssets($assets))) {
            return implode("\n", $this->renderItems($items, $type, false));
        }
    }

    /**
     * Rendre les éléments de position donnés sur un tableau d'actifs.
     *
     * @param  array $items
     * @param string $type
     * @param bool $sorted
     *
     * @return array
     */
    protected function renderItems(array $items, $type, $sorted = true)
    {
        if ($sorted) {
            static::sortItems($items);
        }

        return array_map(function ($item) use ($type)
        {
            $asset = Arr::get($item, 'asset');

            //
            $mode = Arr::get($item, 'mode', 'default');

            if ($mode === 'inline') {
                $asset = sprintf("\n%s\n", trim($asset));
            }

            // Le mode « affichage » est un mode « en ligne » spécialisé
            else if ($mode === 'view') {
                $mode = 'inline';

                $asset = $this->views->fetch($asset);
            }

            $template = Arr::get(static::$templates, "{$mode}.{$type}");

            return sprintf($template, $asset);

        }, $items);
    }

    /**
     * Triez les éléments donnés par ordre.
     *
     * @param  array $items
     *
     * @return void
     */
    protected static function sortItems(array &$items)
    {
        usort($items, function ($a, $b)
        {
            if ($a['order'] === $b['order']) {
                return 0;
            }

            return ($a['order'] < $b['order']) ? -1 : 1;
        });
    }

    /**
     * Analyse et renvoie les actifs donnés.
     *
     * @param  string|array $assets
     * @param  int $order
     * @param  string $mode
     *
     * @return array
     */
    protected function parseAssets($assets, $order = 0, $mode = 'default')
    {
        if (is_string($assets) && ! empty($assets)) {
            $assets = array($assets);
        } else if (! is_array($assets)) {
            return array();
        }

        return array_map(function ($asset) use ($order, $mode)
        {
            return compact('asset', 'order', 'mode');

        }, array_filter($assets, function ($value)
        {
            return ! empty($value);
        }));
    }
}
