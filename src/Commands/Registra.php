<?php

namespace DervisGroup\Pesa\Commands;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use DervisGroup\Pesa\Mpesa\Library\RegisterUrl;

/**
 * Class Registra
 * @package DervisGroup\Pesa\Commands
 */
class Registra extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mpesa:register_url';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register mpesa validation and confirmation URL';
    /**
     * @var RegisterUrl
     */
    private $registerUrl;

    /**
     * Create a new command instance.
     *
     * @param RegisterUrl $registerUrl
     */
    public function __construct(RegisterUrl $registerUrl)
    {
        parent::__construct();
        $this->registerUrl = $registerUrl;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws GuzzleException
     * @throws \Exception
     * @throws \DervisGroup\Pesa\Exceptions\MpesaException
     */
    public function handle()
    {
        $register = $this->registerUrl
            ->register($this->askShortcode())
            ->onConfirmation($this->askConfirmationUrl())
            ->onValidation($this->askValidationUrl())
            ->submit();
        dd($register);
    }

    private function askShortcode(): string
    {
        return $this->ask('What is your shortcode', \config('pesa.c2b.short_code'));
    }

    private function askConfirmationUrl(): string
    {
        return $this->ask('Confirmation Url', \config('pesa.c2b.confirmation_url'));
    }

    private function askValidationUrl(): string
    {
        return $this->ask('Validation Url', \config('pesa.c2b.validation_url'));
    }
}
