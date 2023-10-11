<?php

namespace Triptasoft\Laravo\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use Triptasoft\Laravo\Models\Chart;

class LaravoController extends \TCG\Voyager\Http\Controllers\Controller
{
    public function index(Request $request) {
        $chartData = Chart::orderBy('order', 'asc')->get();
        $charts = [];
        foreach($chartData as $chart){
            $charts[] = $this->createChart([
                'chart_title' => $chart->title,
                'chart_type' => $chart->type,
                'report_type' => $chart->report_type,
                'model' => $chart->model,
                'group_by_field' => $chart->field,
                'relationship_name' => $chart->relation_name,
                'size' => $chart->size,
            ]);
        };
    
        return view('voyager::index')->with('charts', $charts);
    }

    private function createChart($chartOptions) {
        return new LaravelChart($chartOptions);
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
