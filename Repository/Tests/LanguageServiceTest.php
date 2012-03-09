<?php
/**
 * File containing the LanguageServiceTest class
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */

namespace eZ\Publish\API\Repository\Tests;

use \eZ\Publish\API\Repository\Tests\BaseTest;

use \eZ\Publish\API\Repository\Values\Content\LanguageCreateStruct;

/**
 * Test case for operations in the LanguageService using in memory storage.
 *
 * @see eZ\Publish\API\Repository\LanguageService
 * @group integration
 */
class LanguageServiceTest extends BaseTest
{
    /**
     * Test for the newLanguageCreateStruct() method.
     *
     * @return void
     * @see \eZ\Publish\API\Repository\LanguageService::newLanguageCreateStruct()
     * @depends eZ\Publish\API\Repository\Tests\RepositoryTest::testGetContentLanguageService
     */
    public function testNewLanguageCreateStruct()
    {
        $repository = $this->getRepository();

        /* BEGIN: Use Case */
        $languageService = $repository->getContentLanguageService();

        $languageCreate = $languageService->newLanguageCreateStruct();
        /* END: Use Case */

        $this->assertInstanceOf(
            '\eZ\Publish\API\Repository\Values\Content\LanguageCreateStruct',
            $languageCreate
        );
    }

    /**
     * Test for the createLanguage() method.
     *
     * @return \eZ\Publish\API\Repository\Values\Content\Language
     * @see \eZ\Publish\API\Repository\LanguageService::createLanguage()
     * @depends eZ\Publish\API\Repository\Tests\LanguageServiceTest::testNewLanguageCreateStruct
     */
    public function testCreateLanguage()
    {
        $repository = $this->getRepository();

        /* BEGIN: Use Case */
        $languageService = $repository->getContentLanguageService();

        $languageCreate               = $languageService->newLanguageCreateStruct();
        $languageCreate->enabled      = true;
        $languageCreate->name         = 'English (New Zealand)';
        $languageCreate->languageCode = 'eng-NZ';

        $language = $languageService->createLanguage( $languageCreate );
        /* END: Use Case */

        $this->assertInstanceOf(
            '\eZ\Publish\API\Repository\Values\Content\Language',
            $language
        );

        return $language;
    }

    /**
     * Test for the createLanguage() method.
     *
     * @param \eZ\Publish\API\Repository\Values\Content\Language $language
     *
     * @return void
     * @see \eZ\Publish\API\Repository\LanguageService::createLanguage()
     * @depends eZ\Publish\API\Repository\Tests\LanguageServiceTest::testCreateLanguage
     */
    public function testCreateLanguageSetsIdPropertyOnReturnedLanguage( $language )
    {
        $this->assertNotNull( $language->id );
    }

    /**
     * Test for the createLanguage() method.
     *
     * @param \eZ\Publish\API\Repository\Values\Content\Language $language
     *
     * @return void
     * @see \eZ\Publish\API\Repository\LanguageService::createLanguage()
     * @depends eZ\Publish\API\Repository\Tests\LanguageServiceTest::testCreateLanguage
     */
    public function testCreateLanguageSetsExpectedProperties( $language )
    {
        $this->assertEquals(
            array(
                true,
                'English (New Zealand)',
                'eng-NZ'
            ),
            array(
                $language->enabled,
                $language->name,
                $language->languageCode
            )
        );
    }

    /**
     * Test for the createLanguage() method.
     *
     * @return void
     * @see \eZ\Publish\API\Repository\LanguageService::createLanguage()
     * @expectedException \eZ\Publish\API\Repository\Exceptions\InvalidArgumentException
     * @depends eZ\Publish\API\Repository\Tests\LanguageServiceTest::testCreateLanguage
     */
    public function testCreateLanguageThrowsInvalidArgumentException()
    {
        $repository = $this->getRepository();

        /* BEGIN: Use Case */
        $languageService = $repository->getContentLanguageService();

        $languageCreate               = $languageService->newLanguageCreateStruct();
        $languageCreate->enabled      = true;
        $languageCreate->name         = 'Norwegian';
        $languageCreate->languageCode = 'nor-NO';

        $languageService->createLanguage( $languageCreate );

        // This call should fail with an InvalidArgumentException, because
        // the language code "nor-NO" already exists.
        $languageService->createLanguage( $languageCreate );
        /* END: Use Case */
    }

    /**
     * Test for the loadLanguageById() method.
     *
     *
     *
     * @return void
     * @see \eZ\Publish\API\Repository\LanguageService::loadLanguageById()
     * @depends eZ\Publish\API\Repository\Tests\LanguageServiceTest::testCreateLanguage
     */
    public function testLoadLanguageById()
    {
        $repository = $this->getRepository();

        /* BEGIN: Use Case */
        $languageService = $repository->getContentLanguageService();

        $languageCreate               = $languageService->newLanguageCreateStruct();
        $languageCreate->enabled      = false;
        $languageCreate->name         = 'English';
        $languageCreate->languageCode = 'eng-NZ';

        $languageId = $languageService->createLanguage( $languageCreate )->id;

        $language = $languageService->loadLanguageById( $languageId );
        /* END: Use Case */

        $this->assertInstanceOf(
            '\eZ\Publish\API\Repository\Values\Content\Language',
            $language
        );
    }

    /**
     * Test for the loadLanguageById() method.
     *
     * @return void
     * @see \eZ\Publish\API\Repository\LanguageService::loadLanguageById()
     * @expectedException \eZ\Publish\API\Repository\Exceptions\NotFoundException
     * @depends eZ\Publish\API\Repository\Tests\LanguageServiceTest::testLoadLanguageById
     */
    public function testLoadLanguageByIdThrowsNotFoundException()
    {
        $repository = $this->getRepository();

        /* BEGIN: Use Case */
        $languageService = $repository->getContentLanguageService();

        // This call should fail with a "NotFoundException"
        $languageService->loadLanguageById( 2342 );
        /* END: Use Case */
    }

    /**
     * Test for the updateLanguageName() method.
     *
     * @return void
     * @see \eZ\Publish\API\Repository\LanguageService::updateLanguageName()
     * @depends eZ\Publish\API\Repository\Tests\LanguageServiceTest::testLoadLanguageById
     */
    public function testUpdateLanguageName()
    {
        $repository = $this->getRepository();

        /* BEGIN: Use Case */
        $languageService = $repository->getContentLanguageService();

        $languageCreate               = $languageService->newLanguageCreateStruct();
        $languageCreate->enabled      = false;
        $languageCreate->name         = 'English';
        $languageCreate->languageCode = 'eng-NZ';

        $languageId = $languageService->createLanguage( $languageCreate )->id;

        $language = $languageService->loadLanguageById( $languageId );

        $updatedLanguage = $languageService->updateLanguageName(
            $language,
            'New language name.'
        );
        /* END: Use Case */

        // Verify that the service returns an updated language instance.
        $this->assertInstanceOf(
            '\eZ\Publish\API\Repository\Values\Content\Language',
            $updatedLanguage
        );

        // Verify that the service also persists the changes
        $updatedLanguage = $languageService->loadLanguageById( $languageId );

        $this->assertEquals( 'New language name.', $updatedLanguage->name );
    }

    /**
     * Test for the enableLanguage() method.
     *
     * @return void
     * @see \eZ\Publish\API\Repository\LanguageService::enableLanguage()
     * @depends eZ\Publish\API\Repository\Tests\LanguageServiceTest::testLoadLanguageById
     */
    public function testEnableLanguage()
    {
        $repository = $this->getRepository();

        /* BEGIN: Use Case */
        $languageService = $repository->getContentLanguageService();

        $languageCreate               = $languageService->newLanguageCreateStruct();
        $languageCreate->enabled      = false;
        $languageCreate->name         = 'English';
        $languageCreate->languageCode = 'eng-NZ';

        $language = $languageService->createLanguage( $languageCreate );

        // Now lets enable the newly created language
        $languageService->enableLanguage( $language );

        $enabledLanguage = $languageService->loadLanguageById( $language->id );
        /* END: Use Case */

        $this->assertTrue( $enabledLanguage->enabled );
    }

    /**
     * Test for the disableLanguage() method.
     *
     * @return void
     * @see \eZ\Publish\API\Repository\LanguageService::disableLanguage()
     * @depends eZ\Publish\API\Repository\Tests\LanguageServiceTest::testLoadLanguageById
     */
    public function testDisableLanguage()
    {
        $repository = $this->getRepository();

        /* BEGIN: Use Case */
        $languageService = $repository->getContentLanguageService();

        $languageCreate               = $languageService->newLanguageCreateStruct();
        $languageCreate->enabled      = true;
        $languageCreate->name         = 'English';
        $languageCreate->languageCode = 'eng-NZ';

        $language = $languageService->createLanguage( $languageCreate );

        // Now lets disable the newly created language
        $languageService->disableLanguage( $language );

        $enabledLanguage = $languageService->loadLanguageById( $language->id );
        /* END: Use Case */

        $this->assertFalse( $enabledLanguage->enabled );
    }

    /**
     * Test for the loadLanguage() method.
     *
     * @return void
     * @see \eZ\Publish\API\Repository\LanguageService::loadLanguage()
     * @depends eZ\Publish\API\Repository\Tests\LanguageServiceTest::testCreateLanguage
     */
    public function testLoadLanguage()
    {
        $repository = $this->getRepository();

        /* BEGIN: Use Case */
        $languageService = $repository->getContentLanguageService();

        $languageCreate               = $languageService->newLanguageCreateStruct();
        $languageCreate->enabled      = true;
        $languageCreate->name         = 'English';
        $languageCreate->languageCode = 'eng-NZ';

        $languageId = $languageService->createLanguage( $languageCreate )->id;

        // Now load the newly created language by it's language code
        $language = $languageService->loadLanguage( 'eng-NZ' );
        /* END: Use Case */

        $this->assertEquals( $languageId, $language->id );
    }

    /**
     * Test for the loadLanguage() method.
     *
     * @return void
     * @see \eZ\Publish\API\Repository\LanguageService::loadLanguage()
     * @expectedException \eZ\Publish\API\Repository\Exceptions\NotFoundException
     * @depends eZ\Publish\API\Repository\Tests\LanguageServiceTest::testLoadLanguage
     */
    public function testLoadLanguageThrowsNotFoundException()
    {
        $repository = $this->getRepository();

        /* BEGIN: Use Case */
        $languageService = $repository->getContentLanguageService();

        // This call should fail with an exception
        $languageService->loadLanguage( 'fre-FR' );
        /* END: Use Case */
    }

    /**
     * Test for the loadLanguages() method.
     *
     * @return void
     * @see \eZ\Publish\API\Repository\LanguageService::loadLanguages()
     * @depends eZ\Publish\API\Repository\Tests\LanguageServiceTest::testCreateLanguage
     */
    public function testLoadLanguages()
    {
        $repository = $this->getRepository();

        /* BEGIN: Use Case */
        $languageService = $repository->getContentLanguageService();

        // Create some languages
        $languageCreateEnglish               = $languageService->newLanguageCreateStruct();
        $languageCreateEnglish->enabled      = false;
        $languageCreateEnglish->name         = 'English';
        $languageCreateEnglish->languageCode = 'eng-NZ';

        $languageCreateFrench               = $languageService->newLanguageCreateStruct();
        $languageCreateFrench->enabled      = false;
        $languageCreateFrench->name         = 'French';
        $languageCreateFrench->languageCode = 'fre-FR';

        $languageService->createLanguage( $languageCreateEnglish );
        $languageService->createLanguage( $languageCreateFrench );

        $languages = $languageService->loadLanguages();
        foreach ( $languages as $language )
        {
            // Operate on each language
        }
        /* END: Use Case */

        $this->assertEquals( 4, count( $languages ) );
    }

    /**
     * Test for the loadLanguages() method.
     *
     * @return void
     * @see \eZ\Publish\API\Repository\LanguageService::loadLanguages()
     * @depends eZ\Publish\API\Repository\Tests\LanguageServiceTest::testCreateLanguage
     */
    public function loadLanguagesReturnsAnEmptyArrayByDefault()
    {
        $repository = $this->getRepository();

        $languageService = $repository->getContentLanguageService();

        $this->assertSame( array(), $languageService->loadLanguages() );
    }

    /**
     * Test for the deleteLanguage() method.
     *
     * @return void
     * @see \eZ\Publish\API\Repository\LanguageService::deleteLanguage()
     * @d epends eZ\Publish\API\Repository\Tests\LanguageServiceTest::testLoadLanguages
     */
    public function testDeleteLanguage()
    {
        $repository = $this->getRepository();

        /* BEGIN: Use Case */
        $languageService = $repository->getContentLanguageService();

        $languageCreateEnglish               = $languageService->newLanguageCreateStruct();
        $languageCreateEnglish->enabled      = false;
        $languageCreateEnglish->name         = 'English';
        $languageCreateEnglish->languageCode = 'eng-NZ';

        $language = $languageService->createLanguage( $languageCreateEnglish );

        // Delete the newly created language
        $languageService->deleteLanguage( $language );
        /* END: Use Case */

        $this->assertEquals( 2, count( $languageService->loadLanguages() ) );
    }

    /**
     * Test for the deleteLanguage() method.
     *
     * NOTE: This test has a dependency against several methods in the content
     * service, but because there is no topological sort for test dependencies
     * we cannot declare them here.
     *
     * @return void
     * @see \eZ\Publish\API\Repository\LanguageService::deleteLanguage()
     * @expectedException \eZ\Publish\API\Repository\Exceptions\InvalidArgumentException
     * @depends eZ\Publish\API\Repository\Tests\LanguageServiceTest::testDeleteLanguage
     * @depend(s) eZ\Publish\API\Repository\Tests\ContentServiceTest::testPublishVersion
     */
    public function testDeleteLanguageThrowsInvalidArgumentException()
    {
        $repository = $this->getRepository();

        /* BEGIN: Use Case */
        // ID of the "Editors" user group in an eZ Publish demo installation
        $editorsGroupId = 13;

        $languageService = $repository->getContentLanguageService();

        $languageCreateEnglish               = $languageService->newLanguageCreateStruct();
        $languageCreateEnglish->enabled      = true;
        $languageCreateEnglish->name         = 'English';
        $languageCreateEnglish->languageCode = 'eng-NZ';

        $language = $languageService->createLanguage( $languageCreateEnglish );

        $contentService = $repository->getContentService();

        // Get metadata update struct and set new language as main language.
        $metadataUpdate = $contentService->newContentMetadataUpdateStruct();
        $metadataUpdate->mainLanguageCode = 'eng-NZ';

        // Update content object
        $contentService->updateContentMetadata(
            $contentService->loadContentInfo( $editorsGroupId ),
            $metadataUpdate
        );

        // This call will fail with an "InvalidArgumentException", because the
        // new language is used by a content object.
        $languageService->deleteLanguage( $language );
        /* END: Use Case */
    }

    /**
     * Test for the getDefaultLanguageCode() method.
     *
     * @return void
     * @see \eZ\Publish\API\Repository\LanguageService::getDefaultLanguageCode()
     */
    public function testGetDefaultLanguageCode()
    {
        $repository      = $this->getRepository();
        $languageService = $repository->getContentLanguageService();

        $this->assertRegExp(
            '(^[a-z]{3}\-[A-Z]{2}$)',
            $languageService->getDefaultLanguageCode()
        );
    }

    /**
     * Helper method that creates a new language test fixture in the
     * API implementation under test.
     *
     * @return \eZ\Publish\API\Repository\Values\Content\Language
     */
    private function createLanguage()
    {
        $repository = $this->getRepository();

        $languageService = $repository->getContentLanguageService();
        $languageCreate  = $languageService->newLanguageCreateStruct();

        $languageCreate->enabled      = false;
        $languageCreate->name         = 'English';
        $languageCreate->languageCode = 'eng-US';

        return $languageService->createLanguage( $languageCreate );
    }
}
