<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;
use App\Models\Article;

class ScrapeBeyondChats extends Command
{
    protected $signature = 'scrape:beyondchats';
    protected $description = 'Scrape the 5 OLDEST articles from BeyondChats blog';

    public function handle()
    {
        $this->info('Starting Phase-1 scraping (robust mode)...');

        // 1️⃣ Load main blogs page
        $response = Http::withoutVerifying()->get('https://beyondchats.com/blogs/');
        if (!$response->successful()) {
            $this->error('Failed to load blogs page');
            return Command::FAILURE;
        }

        $crawler = new Crawler($response->body());

        // 2️⃣ Detect last page number
        $lastPage = 1;
        $crawler->filter('.pagination a')->each(function ($node) use (&$lastPage) {
            if (is_numeric(trim($node->text()))) {
                $lastPage = max($lastPage, (int) trim($node->text()));
            }
        });

        $this->info("Detected last page: $lastPage");

        // 3️⃣ Collect article URLs from last page backwards
        $articleUrls = collect();
        $page = $lastPage;

        while ($articleUrls->count() < 5 && $page > 0) {
            $this->info("Scanning page: $page");

            $pageResponse = Http::withoutVerifying()
                ->get("https://beyondchats.com/blogs/page/$page");

            if (!$pageResponse->successful()) {
                $page--;
                continue;
            }

            $pageCrawler = new Crawler($pageResponse->body());

            // 🔥 ROBUST LINK COLLECTION (NO DOM ASSUMPTIONS)
            $links = $pageCrawler->filter('a[href^="/blogs/"]')
                ->each(fn ($node) => $node->attr('href'));

            $links = collect($links)
                ->filter(fn ($l) =>
                    $l !== '/blogs/' &&
                    !str_contains($l, '/page/')
                )
                ->unique()
                ->values();

            foreach ($links as $link) {
                if ($articleUrls->count() < 5) {
                    $articleUrls->push($link);
                }
            }

            $page--;
        }

        if ($articleUrls->isEmpty()) {
            $this->error('No article URLs found after scanning pages.');
            return Command::FAILURE;
        }

        // 4️⃣ Clear previous original articles
        Article::where('type', 'original')->delete();
        $this->info('Cleared previous original articles');

        // 5️⃣ Scrape and store articles
        foreach ($articleUrls as $href) {
            $url = 'https://beyondchats.com' . $href;

            try {
                $this->info("Scraping: $url");

                $detail = Http::withoutVerifying()->get($url);
                if (!$detail->successful()) {
                    continue;
                }

                $detailCrawler = new Crawler($detail->body());

                $title = $detailCrawler->filter('h1')->count()
                    ? trim($detailCrawler->filter('h1')->text())
                    : 'Untitled Article';

                $content = $detailCrawler->filter('article')->count()
                    ? trim($detailCrawler->filter('article')->text())
                    : trim($detailCrawler->filter('body')->text());

                Article::create([
                    'title'      => $title,
                    'content'    => substr($content, 0, 15000),
                    'source_url' => $url,
                    'type'       => 'original',
                    'references' => null,
                ]);

                $this->info("Inserted: $title");

            } catch (\Exception $e) {
                $this->warn('Skipped article due to parsing error');
            }
        }

        $this->info('Phase-1 scraping completed successfully.');
        return Command::SUCCESS;
    }
}
