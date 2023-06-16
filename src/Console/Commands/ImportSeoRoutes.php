<?php

namespace Codedor\Seo\Console\Commands;

use Codedor\Seo\SeoRoutes;
use Illuminate\Console\Command;

class ImportSeoRoutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seo:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Seo Routes from routes/web.php to database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $seoRoutes = SeoRoutes::list();

        $count = 0;
        foreach ($seoRoutes as $route) {
            config('seo.seo_routes_model')::updateOrCreate(
                [
                    'route' => $route['as'],
                ],
                [
                    'route' => $route['as'],
                    'og_type' => 'website',
                ]
            );

            $count++;
        }

        if ($count === 1) {
            $this->info('1 seo route has been added/updated');
        } else {
            $this->info(sprintf('%s seo routes has been added/updated', $count));
        }
    }
}
