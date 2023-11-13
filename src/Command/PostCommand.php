<?php

namespace App\Command;

use App\Service\MealManager\MealManager;
use App\Service\MealReader\Meal;
use Mov\BlueskyApi\BlueskyApi;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[AsCommand(name: 'bluesky:post:meal')]
class PostCommand extends Command
{

    private BlueskyApi $blueskyApi;

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function __construct(
        private readonly MealManager $mealManager,
        string                       $user,
        string                       $password,
    ) {
       $this->blueskyApi = new BlueskyApi();
       $this->blueskyApi->authenticate($user, $password);

       parent::__construct();
    }

    /**
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $meal = $this->mealManager->getMeal();

        if (null === $meal) {
            return Command::SUCCESS;
        }

        $responseJson = $this->blueskyApi->uploadBlob(file_get_contents($meal->getImage()), mime_content_type($meal->getImage()));
        $response = json_decode($responseJson, true);
        $this->blueskyApi->post($this->getSkeet($meal), $this->buildEmbed($response['blob'], $meal->getTitle()), ['en']);

        unlink($meal->getImage());

        return Command::SUCCESS;
    }

    private function getSkeet(Meal $meal): string
    {
        $skeet = '🍽 ' . $meal->getTitle() . PHP_EOL;
        $skeet .= '🔠 ' . $meal->getCategory() . PHP_EOL;
        $skeet .= '🌍 ' . $meal->getArea();
        $skeet .= PHP_EOL . PHP_EOL;
        if (null !== $meal->getSource()) {
            $skeet .= $meal->getSource();
        }
        return $skeet;
    }

    private function buildEmbed(array $image, string $alt): array
    {
        return [
            '$type' => 'app.bsky.embed.images',
            'images' => [
                [
                    'alt' => $alt,
                    'image' => $image,
                ],
            ]
        ];
    }

}