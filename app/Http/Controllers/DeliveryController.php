<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    private function nominatimHeaders(): array
    {
        return [
            'User-Agent' => 'Rembeka/1.0 (contact@rembekaonline.com)',
            'Accept' => 'application/json',
        ];
    }

    private function haversineDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $R = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2)
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2))
            * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $R * $c;
    }

    public function calculate(Request $request): JsonResponse
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'subtotal' => 'nullable|numeric',
        ]);

        $warehouseLat = (float) config('services.delivery.warehouse_lat', -1.2921);
        $warehouseLng = (float) config('services.delivery.warehouse_lng', 36.8219);
        $baseFee = (float) config('services.delivery.base_fee', 200);
        $perKmRate = (float) config('services.delivery.per_km_rate', 50);
        $freeThresholdKm = (float) config('services.delivery.free_threshold_km', 5);
        $freeMinimumSpend = (float) config('services.delivery.free_minimum_spend', 3000);

        $distanceKm = $this->haversineDistance(
            $warehouseLat,
            $warehouseLng,
            (float) $request->input('latitude'),
            (float) $request->input('longitude')
        );

        $fee = $baseFee + $distanceKm * $perKmRate;

        if ($distanceKm <= $freeThresholdKm) {
            $fee = 0;
        } elseif ($request->filled('subtotal') && $request->input('subtotal') >= $freeMinimumSpend) {
            $fee = 0;
        }

        return response()->json([
            'fee' => (int) round($fee),
            'distanceKm' => round($distanceKm * 100) / 100,
            'method' => 'DELIVERY',
        ]);
    }

    public function geocode(Request $request): JsonResponse
    {
        $request->validate([
            'address' => 'required|string|min:3',
        ]);

        $url = 'https://nominatim.openstreetmap.org/search?format=json&limit=1&q=' . urlencode($request->input('address')) . '&countrycodes=ke&addressdetails=1';

        $opts = [
            'http' => [
                'method' => 'GET',
                'header' => "User-Agent: Rembeka/1.0 (contact@rembekaonline.com)\r\n" .
                            "Accept: application/json\r\n",
                'timeout' => 10,
            ],
        ];

        $response = @file_get_contents($url, false, stream_context_create($opts));
        $data = json_decode($response, true);

        if (empty($data)) {
            return response()->json(['message' => 'Address not found'], 404);
        }

        $place = $data[0];

        return response()->json([
            'latitude' => (float) $place['lat'],
            'longitude' => (float) $place['lon'],
            'displayName' => $place['display_name'],
        ]);
    }

    public function reverseGeocode(Request $request): JsonResponse
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $lat = $request->input('latitude');
        $lng = $request->input('longitude');

        $url = "https://nominatim.openstreetmap.org/reverse?format=json&lat={$lat}&lon={$lng}";

        $opts = [
            'http' => [
                'method' => 'GET',
                'header' => "User-Agent: Rembeka/1.0 (contact@rembekaonline.com)\r\n" .
                            "Accept: application/json\r\n",
                'timeout' => 10,
            ],
        ];

        $response = @file_get_contents($url, false, stream_context_create($opts));
        $data = json_decode($response, true);

        if (isset($data['error'])) {
            return response()->json([
                'latitude' => (float) $lat,
                'longitude' => (float) $lng,
                'displayName' => "{$lat}, {$lng}",
            ]);
        }

        return response()->json([
            'latitude' => (float) $data['lat'],
            'longitude' => (float) $data['lon'],
            'displayName' => $data['display_name'] ?? "{$lat}, {$lng}",
        ]);
    }
}
