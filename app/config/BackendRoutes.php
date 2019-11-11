<?php

use Phalcon\Mvc\Router\Group as RouterGroup;
use Models\Configuration;

class BackendRoutes extends RouterGroup
{
    protected static $prefix;

    public function __construct($config = null)
    {
        self::$prefix = '/' . Configuration::get('ADMIN_PREFIX');
        parent::__construct($config);
        $this->init();
    }

    public function init()
    {
        $this->setPaths(
            [
                'module' => 'backend'
            ]
        );
        $this->add(self::$prefix, [
            'module' => 'backend',
            'controller' => 'index',
            'action' => 'index'
        ])->setName('admin-index-index');
        $this->setPrefix(self::$prefix);
        $this->add('/:controller', [
            'controller' => 1,
            'action' => 'index'
        ]);
        $this->add('/:controller/:action', [
            'controller' => 1,
            'action' => 2
        ]);
        $this->add('/login', [
            'controller' => 'index',
            'action' => 'login'
        ])->setName('admin-index-login');
        $this->add('/logout', [
            'controller' => 'index',
            'action' => 'logout'
        ])->setName('admin-index-logout');
        $this->add('/transliteration', [
            'controller' => 'index',
            'action' => 'transliteration'
        ])->setName('admin-index-transliteration');
        $this->add('/get-translations', array(
            'controller' => 'index',
            'action' => 'getTranslations'
        ))->setName('admin-index-get-translations');
        $this->add('/settings', [
            'controller' => 'settings',
            'action' => 'index'
        ])->setName('admin-settings-index');
        $this->add('/recipes', [
            'controller' => 'recipes',
            'action' => 'index'
        ])->setName('admin-recipes-index');
        $this->add('/recipes', [
            'controller' => 'recipes',
            'action' => 'index'
        ])->setName('admin-recipes-index');
        $this->add('/recipes/add', [
            'controller' => 'recipes',
            'action' => 'add'
        ])->setName('admin-recipes-add');
        $this->add('/translations', [
            'controller' => 'translations',
            'action' => 'index'
        ])->setName('admin-translations-index');
        $this->add('/translations/add', [
            'controller' => 'translations',
            'action' => 'add'
        ])->setName('admin-translations-add');
        $this->add('/translations/delete/:int', [
            'controller' => 'translations',
            'action' => 'delete',
            'id_translation' => 1
        ])->setName('admin-translations-delete');
        $this->add('/translations/parse', [
            'controller' => 'translations',
            'action' => 'parse'
        ])->setName('admin-translations-parse');
//        features
        $this->add('/features', [
            'controller' => 'features',
            'action' => 'index'
        ])->setName('admin-features-index');
        $this->add('/features/view/:int', [
            'controller' => 'features',
            'action' => 'view',
            'id_feature' => 1
        ])->setName('admin-features-view');
        $this->add('/features/update/:int', [
            'controller' => 'features',
            'action' => 'update',
            'id_feature' => 1
        ])->setName('admin-features-update');
        $this->add('/features/delete/:int', [
            'controller' => 'features',
            'action' => 'delete',
            'id_feature' => 1
        ])->setName('admin-features-delete');
        $this->add('/features/add', [
            'controller' => 'features',
            'action' => 'add',
        ])->setName('admin-features-add');
        $this->add('/features/add-value/:int', [
            'controller' => 'features',
            'action' => 'addFeatureValue',
            'id_feature' => 1
        ])->setName('admin-features-add-value');
        $this->add('/features/update-active', [
            'controller' => 'features',
            'action' => 'updateActive',
        ])->setName('admin-features-update-active');
        $this->add('/features/update-position', [
            'controller' => 'features',
            'action' => 'updatePosition',
        ])->setName('admin-features-update-position');
        $this->add('/features/update-value-active', [
            'controller' => 'features',
            'action' => 'updateValueActive',
        ])->setName('admin-features-update-value-active');
        $this->add('/features/update-value-position', [
            'controller' => 'features',
            'action' => 'updateValuePosition',
        ])->setName('admin-features-update-value-position');
        $this->add('/features/update-value/:int', [
            'controller' => 'features',
            'action' => 'updateFeatureValue',
            'id_feature_value' => 1
        ])->setName('admin-features-update-value');
        $this->add('/features/delete-value/:int', [
            'controller' => 'features',
            'action' => 'deleteFeatureValue',
            'id_feature_value' => 1
        ])->setName('admin-features-delete-value');
        $this->add('/categories', [
            'controller' => 'categories',
            'action' => 'index',
        ])->setName('admin-categories-index');
        $this->add('/categories/add', [
            'controller' => 'categories',
            'action' => 'add',
        ])->setName('admin-categories-add');
        $this->add('/categories/update-position', [
            'controller' => 'categories',
            'action' => 'updatePosition',
        ])->setName('admin-categories-update-position');
        $this->add('/categories/update-active', [
            'controller' => 'categories',
            'action' => 'updateActive',
        ])->setName('admin-categories-update-active');
        $this->add('/categories/update/:int', [
            'controller' => 'categories',
            'action' => 'update',
            'id_category' => 1
        ])->setName('admin-categories-update');
        $this->add('/categories/view/:int', [
            'controller' => 'categories',
            'action' => 'view',
            'id_category' => 1
        ])->setName('admin-categories-view');
        $this->add('/categories/delete/:int', [
            'controller' => 'categories',
            'action' => 'delete',
            'id_category' => 1
        ])->setName('admin-categories-delete');
        $this->add('/categories/update-image/:int', [
            'controller' => 'categories',
            'action' => 'updateImage',
            'id_category' => 1
        ])->setName('admin-categories-update-image');
        $this->add('/categories/update-feature/:int', [
            'controller' => 'categories',
            'action' => 'updateFeatures',
            'id_category' => 1
        ])->setName('admin-categories-update-feature');
    }


}