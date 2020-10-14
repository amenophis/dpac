<?php

declare(strict_types=1);

namespace Tests\Func\App\Application\RegisterFarm;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterFarmTest extends WebTestCase
{
    public function testRegisterFarmSuccess(): void
    {
        $client = $this->createClient();
        $client->request('GET', '/register/farm');
        $client->submitForm('Register', [
            'form[firstname]' => 'Jeremy',
            'form[lastname]'  => 'Leherpeur',
            'form[email]'     => 'jleherpeur-biofarm@example.com',
            'form[farmName]'  => 'Bio Farm',
        ]);

        $this->assertResponseStatusCodeSame(302);

        $this->assertEmailCount(1);
        $email = $this->getMailerMessage(0);
        $this->assertEmailHeaderSame($email, 'To', 'Jeremy Leherpeur <jleherpeur-biofarm@example.com>');
        $this->assertEmailTextBodyContains($email, 'Welcome Jeremy Leherpeur !');

        $client->followRedirect();

        $this->assertResponseStatusCodeSame(200);
        $this->assertPageTitleContains('Registration success !');
    }

    /**
     * @dataProvider provideRegisterFarmValidationErrors
     */
    public function testRegisterFarmFormValidationErrors(string $fieldname, string $value, string $expectedError): void
    {
        $formData = [
            'form[firstname]' => 'Jeremy',
            'form[lastname]'  => 'Leherpeur',
            'form[email]'     => 'jleherpeur-biofarm@example.com',
            'form[farmName]'  => 'Bio Farm',
        ];

        $formData["form[{$fieldname}]"] = $value;

        $client = $this->createClient();

        $client->request('GET', '/register/farm');
        $client->submitForm('Register', $formData);

        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorTextContains("#form_{$fieldname}_errors", $expectedError);
    }

    public function provideRegisterFarmValidationErrors(): iterable
    {
        yield 'firstname should not be blank' => [
            'firstname',
            '',
            'This value should not be blank.',
        ];

        yield 'firstname should be at least 2 chars' => [
            'firstname',
            'a',
            'This value is too short. It should have 2 characters or more.',
        ];

        yield 'firstname should be at most 64 chars' => [
            'firstname',
            'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'This value is too long. It should have 64 characters or less.',
        ];

        yield 'lastname should not be blank' => [
            'lastname',
            '',
            'This value should not be blank.',
        ];

        yield 'lastname should be at least 2 chars' => [
            'lastname',
            'a',
            'This value is too short. It should have 2 characters or more.',
        ];

        yield 'lastname should be at most 64 chars' => [
            'lastname',
            'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'This value is too long. It should have 64 characters or less.',
        ];

        yield 'email should not be blank' => [
            'email',
            '',
            'This value should not be blank.',
        ];

        yield 'email should be a valid email address' => [
            'email',
            'a',
            'This value is not a valid email address.',
        ];

        yield 'farmName should not be blank' => [
            'farmName',
            '',
            'This value should not be blank.',
        ];

        yield 'farmName should be at least 2 chars' => [
            'farmName',
            'a',
            'This value is too short. It should have 2 characters or more.',
        ];

        yield 'farmName should be at most 64 chars' => [
            'farmName',
            'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'This value is too long. It should have 64 characters or less.',
        ];
    }
}
