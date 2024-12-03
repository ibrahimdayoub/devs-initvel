<?php

namespace Devs\Initvel\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

/**
 * AppendLangsCommand Class
 *
 * This command sets up multiple language folders and files in the `resources/lang` directory.
 * It creates language-specific folders and adds a `public.php` file for each language containing basic translations.
 */
class AppendLangsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'initvel:setup-langs {languages*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup multi-language folders and files in the resources/lang directory';

    /**
     * Handle the execution of the command.
     *
     * This method retrieves the list of languages provided as arguments,
     * creates the corresponding directories, and writes language files with translations.
     * It also checks if a directory already exists before writing the `public.php` file.
     *
     * @return int
     */
    public function handle()
    {
        // Retrieve the list of languages passed as command arguments
        $languages = $this->argument('languages');

        // Iterate over each language and set up the corresponding directory and file
        foreach ($languages as $lang) {
            $projectLangPath = resource_path("lang/{$lang}");

            // Check if the directory for the language already exists
            if (!File::exists($projectLangPath)) {
                // If it doesn't exist, create the directory and add the public.php file
                File::makeDirectory($projectLangPath, 0755, true);
                File::put("{$projectLangPath}/public.php", $this->stubContent($lang));
                $this->info("Created new language folder and public.php file for language: {$lang}");
            } else {
                // If the directory exists, only add or update the public.php file
                File::put("{$projectLangPath}/public.php", $this->stubContent($lang));
                $this->warn("Language folder already exists for language: {$lang}");
                $this->info("Created public.php file for language: {$lang}");
            }
        }

        // Inform the user that all language files and folders have been set up
        $this->info('All language files and folders have been set up successfully!');
    }

    /**
     * Generate the content of the `public.php` language file based on the language.
     *
     * This method returns an array of translations for the provided language.
     * If the language is not found, it defaults to the 'en' (English) translations.
     *
     * @param string $lang The language code
     * @return string The content of the language file
     */
    private function stubContent($lang)
    {
        // Translation content for different languages
        $content = [
            'en' => [
                'home' => 'Home',
                'about' => 'About Us',
                'contact' => 'Contact Us',
            ],
            'zh' => [
                'home' => '主页',
                'about' => '关于我们',
                'contact' => '联系我们',
            ],
            'es' => [
                'home' => 'Inicio',
                'about' => 'Sobre nosotros',
                'contact' => 'Contáctenos',
            ],
            'ar' => [
                'home' => 'الصفحة الرئيسية',
                'about' => 'من نحن',
                'contact' => 'اتصل بنا',
            ],
            'ru' => [
                'home' => 'Главная',
                'about' => 'О нас',
                'contact' => 'Контакты',
            ],
            'fr' => [
                'home' => 'Accueil',
                'about' => 'À propos de nous',
                'contact' => 'Contactez-nous',
            ],
            'de' => [
                'home' => 'Startseite',
                'about' => 'Über uns',
                'contact' => 'Kontaktieren Sie uns',
            ],
            'pt' => [
                'home' => 'Início',
                'about' => 'Sobre nós',
                'contact' => 'Contate-nos',
            ],
            'it' => [
                'home' => 'Home',
                'about' => 'Chi siamo',
                'contact' => 'Contattaci',
            ],
            'ja' => [
                'home' => 'ホーム',
                'about' => '私たちについて',
                'contact' => 'お問い合わせ',
            ],
            'ko' => [
                'home' => '홈',
                'about' => '우리에 대해',
                'contact' => '연락처',
            ],
        ];        

        // Select the content for the requested language or default to English
        $langContent = $content[$lang] ?? $content['en'];

        // Start constructing the PHP file content
        $stub = "<?php\n\nreturn [\n";

        // Loop through the translations and format them
        foreach ($langContent as $key => $value) {
            $stub .= "    '{$key}' => '{$value}',\n";
        }

        // Close the array and return the content as a string
        $stub .= "];\n";

        return $stub;
    }
}