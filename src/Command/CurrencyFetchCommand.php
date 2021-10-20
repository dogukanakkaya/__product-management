<?php

namespace App\Command;

use App\Entity\Currency;
use Doctrine\ORM\EntityManagerInterface;
use SimpleXMLElement;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'currency:fetch',
    description: 'Fetch the currencies from TCMB',
)]
class CurrencyFetchCommand extends Command
{
    private array $allowedCurrencies = ['USD', 'EUR', 'GBP'];

    public function __construct(private HttpClientInterface $client, private EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $response = $this->client->request(
            'GET',
            'https://www.tcmb.gov.tr/kurlar/today.xml'
        );

        $content = $response->getContent();

        $currencies = new SimpleXMLElement($content);

        foreach ($currencies as $currency) {
            $attributes = $currency->attributes();

            $currencyCode = (string) $attributes['CurrencyCode'] ?? '';

            // Only save allowed currencies to database
            if (!in_array($currencyCode, $this->allowedCurrencies)) {
                continue;
            }

            /** @var Currency $findCurrency */
            $findCurrency = $this->entityManager
                ->getRepository(Currency::class)
                ->findOneBy(['name' => $currencyCode]);

            // Persist each currency to entity manager if not exists or else update the currency
            if (is_null($findCurrency)) {
                $this->entityManager->persist(
                    (new Currency())
                        ->setName($currencyCode)
                );
            } else {
                $findCurrency
                    ->setName($currencyCode);
            }
        }

        $this->entityManager->flush();

        $io->success('[' . implode("|", $this->allowedCurrencies) . '] currencies are added to database.');

        return Command::SUCCESS;
    }
}
