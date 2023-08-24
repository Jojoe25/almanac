<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
class AdminControllerTest extends WebTestCase

{
    private function generateUrl(string $string)
    {
    }

    public function testLogin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Sign in')->form();
        $form['email'] = 'jclement25400@gmail.com';
        $form['password'] = '123456';
        $client->submit($form);

        // on vérifie si le lien de déconnexion est présent apres la connexion :
        $this->assertSelectorExists('a[href="'. $this->generateUrl('app_logout') .'"]');
    }
}




