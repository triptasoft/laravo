<?php

namespace Triptasoft\Laravo\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;
use Triptasoft\Laravo\Charts\LaravoChart;
use Triptasoft\Laravo\Models\Chart;

class LaravoController extends \TCG\Voyager\Http\Controllers\Controller
{
    public function index(Request $request) {
        $chartData = Chart::orderBy('order', 'asc')->get();
        $charts = [];
        foreach($chartData as $chart){
            $charts[] = $this->createChart([
                'chart_title' => $chart->chart_title,
                'report_type' => $chart->report_type,
                'chart_type' => $chart->chart_type,
                'model' => $chart->model,
                'group_by_field' => $chart->group_by_field,
                'relationship_name' => $chart->relationship_name,

                'size' => $chart->size,
                'type' => $chart->type,
                'count' => $chart->model::count(),
            ]);
        };
    
        return view('voyager::index')->with([
            'charts' => $charts,
        ]);
    }

    private function createChart($chartOptions) {
        return new LaravoChart($chartOptions);
    }

    public function count($any)
    {
        $count = $any::count();
        return response()->json([
            'data' => $count,
        ]);
    }

    public function assets(Request $request)
    {
        try {
            if (class_exists(\League\Flysystem\Util::class)) {
                // Flysystem 1.x
                $path = dirname(__DIR__, 3).'/publishable/assets/'.\League\Flysystem\Util::normalizeRelativePath(urldecode($request->path));
            } elseif (class_exists(\League\Flysystem\WhitespacePathNormalizer::class)) {
                // Flysystem >= 2.x
                $normalizer = new \League\Flysystem\WhitespacePathNormalizer();
                $path = dirname(__DIR__, 3).'/publishable/assets/'. $normalizer->normalizePath(urldecode($request->path));
            }
            
        } catch (\LogicException $e) {
            abort(404);
        }

        if (File::exists($path)) {
            $mime = '';
            if (Str::endsWith($path, '.js')) {
                $mime = 'text/javascript';
            } elseif (Str::endsWith($path, '.css')) {
                $mime = 'text/css';
            } else {
                $mime = File::mimeType($path);
            }
            $response = response(File::get($path), 200, ['Content-Type' => $mime]);
            $response->setSharedMaxAge(31536000);
            $response->setMaxAge(31536000);
            $response->setExpires(new \DateTime('+1 year'));

            return $response;
        }

        return response('', 404);
    }
}
