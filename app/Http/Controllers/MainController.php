<?php
/**
 * Created by PhpStorm.
 * User: njohns
 * Date: 7/28/15
 * Time: 12:42 PM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Avalon\Redis\Client as Redis;

/**
 * Class MainController
 * @package App\Http\Controllers
 */
class MainController extends Controller
{
    /**
     * @var Redis
     */
    private $redis;

    /**
     * @param Redis $redis
     */
    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }

    /**
     * Lol wat?! this controller SUCKS! YOLO!
     *
     * @param Request $request
     * @param int $index
     * @return \Illuminate\View\View
     */
    public function index(Request $request, $index = 0)
    {
        $view = [
            'page' => [
                'now' => $index,
                'next' => $index++,
                'prev' => $index--,
            ],
            'user' => $request->user(),
            'containers' => [],
            'datapoints' => []
        ];

        $map = $this->redis->range($index);
        $view['raw'] = json_encode($map, JSON_PRETTY_PRINT);

        if($map) {
            $view['asset']['file'] = $map['file'];

            if(! file_exists(__DIR__ . '/../../../public/' . $view['asset']['file']['path'])) {
                $view['asset']['file']['path'] = '/img/default_asset.png';
            }

            $view['asset']['rights'] = $map['usage_rights'];
            foreach($map['selected_container_tag_ids'] as $tagId) {
                $tag = $this->redis->getTagById($tagId);
                if(! $tag) {
                    continue;
                }

                $view['containers'][$tag['container_tag_id']] = $tag['name'];
            }

            foreach($map['datapoints'] as $id => $values) {
                $datapoint = $this->redis->getDatapointById($id);
                if(! $datapoint) {
                    continue;
                }

                if(is_array($values)) {
                    $validValues = [];
                    if(count($values) <= 1) {
                        $v = array_pop($values);
                        $validValues = $v['valid_value'];
                    } else {
                        foreach ($values as $k => $v) {
                            $validValues[] = $v['valid_value'];
                        }
                    }
                } else {
                    $validValues = $values;
                }

                $view['datapoints'][$datapoint['name']] = $validValues;
            }
        } else {
            $view['asset'] = [
                'file' => [
                    'name' => 'Serious Asset',
                    'path' => '/img/default_asset.png'
                ],

                'rights' => [
                    'name' => 'Serious Rights',
                    'path' => '/img/default_rights.md'
                ],
            ];
        }

        return view('home', $view);
    }
}