<?php

namespace App\Helpers;

use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Log;

class TranslateHelper
{
    /**
     * Translate text from Indonesian to English using Google Translate API.
     *
     * @param string|null $text
     * @return string|null
     */
    public static function translateToEnglish(?string $text): ?string
    {
        if (empty(trim((string)$text))) {
            return $text;
        }

        try {
            $tr = new GoogleTranslate('en');
            $tr->setSource('id');
            return $tr->translate($text);
        } catch (\Exception $e) {
            Log::error('Translation failed: ' . $e->getMessage());
            return null; // Return null or maybe original text on failure? Null is safer for fallback logic
        }
    }
}
