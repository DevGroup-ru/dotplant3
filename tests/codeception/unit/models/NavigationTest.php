<?php

namespace app\tests\codeception\unit\models;

use app\models\Navigation;
use app\tests\codeception\fixtures\NavigationFixture;
use app\tests\codeception\fixtures\NavigationTranslationFixture;

class NavigationTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    public $tester;

    public function testCheckPermissions()
    {
        \Yii::$app->multilingual->language_id = 1;
        \Yii::$app->authManager->defaultRoles = ['NavigationAdministrator'];
        $this->tester->haveFixtures(
            [
                'navigation' => [
                    'class' => NavigationFixture::class,
                ],
                'navigationTranslation' => [
                    'class' => NavigationTranslationFixture::class,
                ],
            ]
        );
        $processedNav = Navigation::getNavigation(null, true);
        $this->assertCount(5, $processedNav);
    }
}
