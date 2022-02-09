<?php
/**
 * @author Jehan Afwazi Ahmad <jehan.afwazi@gmail.com>.
 */

namespace App\Tests\Feature;


class HomeFTest extends \TestCase
{
    /**
     * A basic functional test example.
     * @test
     * @return void
     */
    public function testBasicExample()
    {
        $this->visit('/')
            ->assertResponseOk()
            ->see('Zuragan Assetv1');
    }
}
