<?php

namespace WorkShopBundle\ProjectSymfonyBundle\Tests\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductsControllerTest extends WebTestCase
{

    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();



        // Create a new entry in the database
        $crawler = $client->request('GET', '/products/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /products/");


        $crawler = $client->click($crawler->filter("#createProductLink")->link());

        // Fill in the form and submit it
        $form = $crawler->filter("input[type='submit']")->form(array(
            'products[nombre]'  => 'Nombre de un test',
            'products[description]'  => 'Descripcion',
            'products[code]'  => 'ASDF',
            'products[price]'  => '400',
            'products[brand]'  => '1',
            'products[category]'  => '1'
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('table tbody tr td:contains("Nombre de un test")')->count(), 'No se encuentra el elemento');

        // Edit the entity
        $crawler = $client->click($crawler->filter('table tbody tr td:contains("Nombre de un test")')->parents()->filter(':last-child')->filter("#editProductLink")->link());

        $form = $crawler->filter("input[type='submit']")->form(array(
            'products[nombre]'  => 'Nombre de un test modificado',
            'products[description]'  => 'Descripcion',
            'products[code]'  => 'ASDF',
            'products[price]'  => '400',
            'products[brand]'  => '1',
            'products[category]'  => '1'
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('table tbody tr td:contains("Nombre de un test modificado")')->count(), 'No se encuentra el elemento');

        //$element=$crawler->filter('table tbody tr td:contains("Nombre de un test modificado")')->parents()->parents()->filter(':first-children')->html();

        //die(var_dump($element));
        // Delete the entity
        $crawler = $client->click($crawler->filter('table tbody tr td:contains("Nombre de un test modificado")')->parents()->filter(':last-child')->filter("#deleteProductLink")->link());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Nombre de un test modificado/', $client->getResponse()->getContent());
    }


}
