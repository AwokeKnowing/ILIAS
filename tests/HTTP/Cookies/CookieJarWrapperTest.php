<?php
/**
 * Class CookieJarWrapperTest
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */

namespace ILIAS\HTTP\Cookies;

require_once('./libs/composer/vendor/autoload.php');

/**
 * Class CookieWrapperTest
 *
 * @author                 Nicolas Schäfli <ns@studer-raimann.ch>
 *
 * @runInSeparateProcess
 * @preserveGlobalState    disabled
 * @backupGlobals          disabled
 * @backupStaticAttributes disabled
 */
class CookieJarWrapperTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @Test
     */
    public function testWithDoesNotChangeTheCurrentObject()
    {

        $cookieName = "YummyCookie";
        $cookieValue = "MilkAndChocolate";
        $cookie = CookieWrapper::create($cookieName, $cookieValue);
        $cookieJar = CookieJarWrapper::fromCookieStrings([]);

        $newCookieJar = $cookieJar->with($cookie);

        $this->assertFalse($cookieJar->has($cookieName));
        $this->assertTrue($newCookieJar->has($cookieName));

        $this->assertNotEquals($cookieJar, $newCookieJar);
    }

    /**
     * @Test
     */
    public function testWithoutDoesNotChangeTheCurrentObject()
    {
        $cookieName = "YummyCookie";
        $cookieValue = "MilkAndChocolate";

        //create a new jar with one cookie
        $cookieJar = CookieJarWrapper::fromCookieStrings([$cookieName . '=' .$cookieValue . ';']);

        //remove cookie
        $newCookieJar = $cookieJar->without($cookieName);

        //old jar should hold the cookie
        $this->assertTrue($cookieJar->has($cookieName));

        //new jar should no longer hold the cookie
        $this->assertFalse($newCookieJar->has($cookieName));

        //check that both are not equal (checked because the has function could fail due to a change in the future)
        $this->assertNotEquals($cookieJar, $newCookieJar);
    }
}
