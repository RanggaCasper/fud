<?php

namespace App\Http\Controllers\Owner;

use Illuminate\Http\Request;
use App\Services\GeminiService;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SeoController extends Controller
{
    public function index()
    {
        return view('owner.seo');
    }

    public function update(Request $request)
    {
        $request->validate([
            'meta_title'        => 'required|string|max:60',
            'meta_description'  => 'required|string|max:160',
            'meta_keywords'     => 'required|string',
        ]);

        try {
            $restaurant = Auth::user()->owned->restaurant;

            $restaurant->metaTag()->updateOrCreate([], [
                'meta_title'        => $request->input('meta_title'),
                'meta_description'  => $request->input('meta_description'),
                'meta_keywords'     => array_filter(array_map('trim', explode(',', $request->input('meta_keywords')))),
            ]);

            return ResponseFormatter::success('Restaurant details updated successfully.', $restaurant);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function generate(GeminiService $gemini)
    {
        try {
            $restaurant = Auth::user()->owned->restaurant;

            $prompt = <<<PROMPT
Please generate SEO metadata based on the restaurant information below:

1. A meta description (maximum 160 characters)
2. A list of at least 5 relevant SEO keywords (as an array)
3. A compelling and concise meta title (maximum 60 characters)

Restaurant information:
- Name: {$restaurant->name}
- Location: {$restaurant->address}
- Offerings: {$restaurant->offerings}
- Opening hours: {$restaurant->operatingHours}
- Dining options: {$restaurant->diningOptions}
- Accessibility features: {$restaurant->accessibilities}
- Payment methods: {$restaurant->payments}

Respond only in JSON format as shown:
{
  "meta_title": "...",
  "meta_description": "...",
  "meta_keywords": ["...", "..."]
}
PROMPT;

            $result = $gemini->generateContent($prompt);

            if (!$result['success']) {
                return ResponseFormatter::error(
                    $result['error'] ?? 'Gagal menghasilkan metadata.',
                    500
                );
            }

            $raw = $result['raw'];
            $clean = trim($raw);
            $clean = preg_replace('/^```json|```$/m', '', $clean);
            $json = json_decode(trim($clean), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return ResponseFormatter::error('Gagal memproses hasil dari AI.', 500);
            }

            return ResponseFormatter::success('SEO metadata generated successfully.', [
                'meta_title' => $json['meta_title'] ?? '',
                'meta_description' => $json['meta_description'] ?? '',
                'meta_keywords' => $json['meta_keywords'] ?? [],
            ]);
        } catch (\Throwable $e) {
            return ResponseFormatter::handleError($e);
        }
    }
}
